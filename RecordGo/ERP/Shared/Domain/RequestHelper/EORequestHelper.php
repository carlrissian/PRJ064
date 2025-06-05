<?php

namespace Shared\Domain\RequestHelper;

use Shared\Domain\Logs\LogHelper;

/**
 * Clase para realizar peticiónes a SAP
 * Necesario configuración en fichero .env de los valores:
 * SAP_COMPANY_DB, SAP_USER_NAME, SAP_PASSWORD, SAP_LOGIN_URL, URL_SAP, APP_NAME
 */
class EORequestHelper implements RequestHelperInterface
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var LogHelper
     */
    private $logHelper;

    /**
     * Inicializa variables para obtener credenciales desde archivo .env
     *
     * @param LogHelper $logHelper
     */
    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
        $this->url = $_ENV['SAP_URL'];
    }


    function request($method, $functionName, $body, $newUrl = null)
    {
        $url = $newUrl ?? $this->url;
        $completeUrl = $url . $functionName;


        $ch = curl_init();

        try {
            $headerCookie = "Cookie: " . $_SESSION["SapSessionId"] . "; Path=/; Domain=https://vm-sap-cockpit.recordgo.cloud;";
        } catch (\Exception $e) {
            throw new \Exception("SAP Session expired", 401);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            $headerCookie,
            "Content-Type:application/json",
        ));

        return $this->curlRequest($body, $ch, $method, $completeUrl);
    }

    private function curlRequest($body, $ch, $method, $completeUrl)
    {
        curl_setopt($ch, CURLOPT_URL, $completeUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,  CURLOPT_HEADER,  false);

        // Evita verificación ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $response = curl_exec($ch);

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code

        $error = curl_error($ch);

        // Si hay error en la petición se guarda en el log
        if (curl_errno($ch) || $statusCode >= 400) {
            $this->logHelper->log($method, $statusCode, $_SERVER['REMOTE_ADDR'], 'Body: ' . json_encode($body) . ' Response: ' . json_encode($response . ' ' . curl_error($ch)), 'ERROR');
        }

        // ACTUALIZAR TIEMPO TOKEN SAP SI NO HAY ERROR
        $successResponseCodes = [200, 201, 202, 203, 204];
        if (in_array($statusCode, $successResponseCodes)) {
            $now = new \DateTime();
            $_SESSION["NextSapSessionId"] = $now->getTimestamp() + $_ENV['SAP_TOKEN_LIMIT_MINUTES'] * 60;
        }

        // SI ES CODIGO 401, SE BORRAN CREDENCIALES
        if ($statusCode == 401) {
            throw new \Exception("SAP Session expired", 401);
        }

        curl_close($ch);

        return $response;
    }
}
