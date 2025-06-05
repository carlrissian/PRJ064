<?php

namespace Shared\Domain\RequestHelper;

use Exception;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\Logs\LogHelper;
use Shared\Domain\OperationResponse;

/**
 * Clase para realizar peticiónes a SAP
 * Necesario configuración en fichero .env de los valores:
 * SAP_COMPANY_DB, SAP_USER_NAME, SAP_PASSWORD, SAP_LOGIN_URL, URL_MIDDLEWARE, APP_NAME
 */
class SapRequestHelper implements RequestHelperInterface
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
        $this->url = $_ENV['URL_MIDDLEWARE'];
    }

    /**
     * GET|POST @param $method
     * Nombre de la función @param $functionName
     * Contenido del mensaje @param $body
     * @return bool|string
     */
    function request($method, $functionName, $body, $headersOptional = [], $activeLog = true)
    {
        $completeUrl = $this->url . $functionName;

        $ch = curl_init();

        try {
            $headerCookie = "Cookie: " . $_SESSION["SapSessionId"] . "; Path=/; Domain=https://vm-sap-cockpit.recordgo.cloud;";
        } catch (\Exception $e) {
            throw new \Exception("SAP Session expired", 401);
        }

        $headers = array(
            $headerCookie,
            "Content-Type:application/json"
        );

        $headers = array_merge($headers, $headersOptional);
        $headers = array_values($headers);

        $country = $_SESSION['target-schema-country'] ?? $_SESSION['SELECTED_COUNTRY_ISO'] ?? null;
        if ($country) {
            $headers[] = 'target-schema-country:' . $country;
            unset($_SESSION['target-schema-country']);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $this->curlRequest($body, $ch, $method, $completeUrl, $activeLog);
    }


    /**
     * Caso de uso exclusivo para la carga del listado de países en el login
     *
     * @param string $method GET|POST
     * @param string $functionName Nombre de la función
     * @param string $body Contenido del mensaje
     * @return bool|string
     */
    function requestWithoutAuth($method, $functionName, $body)
    {
        $completeUrl = $this->url . $functionName;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:application/json",
        ));

        return $this->curlRequest($body, $ch, $method, $completeUrl, false);
    }

    function basicAuthRequest($method, $functionName, $body, $country_iso)
    {
        $completeUrl = $this->url . $functionName;
        $username = 'webrgo';
        $password = (isset($_ENV['BASIC_AUTO_PRODUCTION']) && $_ENV['BASIC_AUTO_PRODUCTION']) ? '!qE3sSdasE_S,' : 'uHfgt283=?zQ';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'target-schema-country: ' . $country_iso,
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$username:$password")
        ));

        return $this->curlRequest($body, $ch, $method, $completeUrl);
    }

    private function curlRequest($body, $ch, $method, $completeUrl, $activeLog = true)
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

        // LOGS
		if ($activeLog){
			$this->handleLogs($ch, $method, $body, $response, $statusCode, $completeUrl);
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

        $this->errorHandling($response);

        return $response;
    }

    private function errorHandling(string $response): void
    {
        $responseArray = json_decode($response, true);

        if (isset($responseArray['errorCode']) ) {
            $code = is_numeric($responseArray['errorCode']) ? $responseArray['errorCode'] : 500;
            $message = $this->determineErrorMessage($responseArray, $code);

            throw new Exception($message, $code);
        }
    }

    private function determineErrorMessage($responseArray,$code): string
    {
        $notasOperationResponse = $this->getNotasOperationResponse($responseArray);

        if (!is_null($notasOperationResponse)) {
            return $notasOperationResponse->getMessage();
        }

        switch ($code) {
            case 460:
                $message = $responseArray['Notas'];
                break;
            case 500:
                $message = $responseArray['errorDescription'].': Check the error with the development department.';
                break;
            default:
                $message = $responseArray['errorDescription'];
                break;
        }
        return $message;
    }

    private function getNotasOperationResponse($responseArray): ?OperationResponse
    {
        if (isset($responseArray['Notas']) && $this->isJson($responseArray['Notas'])) {
            $notasArray = json_decode($responseArray['Notas'], true);
            try {
                return OperationResponse::createFromArray($notasArray);
            } catch (\Exception $e) {
                // Ignorar y continuar si no se puede crear el objeto
            }
        }
        return null;
    }

    private function isJson($string): bool
    {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
    }

    private function handleLogs($ch, $method, $body, $response, $statusCode, $completeUrl)
    {
        $body = (strlen($bodyTemp = json_encode($body)) > 100000) ? ['Body is too long to show in logs.'] : $bodyTemp;

        // ENVIAR LOGS SI HAY ERROR O SI ES UNA PETICIÓN CON ENABLE_INFO_LOGS = 1
        $logsEnabled = ConstantsJsonFile::getValue('ENABLE_INFO_LOGS_'.$_ENV['CONSTANTS_KEY_SATELLITE']);

        // Si hay error en la petición se guarda en el log
        $errno = curl_errno($ch);
        if ($errno) {
            $type = 'ERROR';
            $error = curl_error($ch);
            $message = '['.$type.']['.$_ENV['APP_NAME'].']['.$method.']: Url: '.$completeUrl.' Body: ' . $body . ' Response: ' .$response . ' Error: ' . $error;
            $this->logHelper->log($method, $statusCode, $_SERVER['REMOTE_ADDR'], $message, $type);
        }

        $responseArray = json_decode($response, true);
        //Si hay error controlado desde MW se guarda en el log
        if(isset($responseArray['errorCode'])){
            $type = 'ERROR';
            $message = '['.$type.']['.$_ENV['APP_NAME'].']['.$method.']: Url: '.$completeUrl.' Error code: '.$responseArray['errorCode']. ' Body: ' . $body . ' Response: ' .$responseArray['errorDescription'] .': '.$responseArray['Notas'];
            $this->logHelper->log($method, $statusCode, $_SERVER['REMOTE_ADDR'], $message, $type);

        }elseif($logsEnabled === '1'){ // Si no hay error y Logs están activados se guarda en el log

            if($body === '' || $body === null){
                $body = [];
            }

            if(!is_array($body)){
                $body = json_decode($body, true);
            }

            if(!empty($body) && is_array($body)){
                foreach($body as $key => $value){
                    if(is_array($value)){
                        $newValue = $value;
                        if($key === "TFilterRequest"){
                            foreach ($value as $k => $v){
                                $newValue[$k] = $v;
                                if($k === "TFilter") {
                                    foreach ($v as $a => $b) {
                                        if($b["field"] === 'PASSWORD' || $b["field"] === 'password' || $b["field"] === 'Password'){
                                            $b["value"] = '********';
                                        }
                                        $newValue[$k][$a] = $b;
                                    }
                                }
                            }
                        }
                        $body[$key] = json_encode($newValue);
                    }elseif(strlen($value) > 200){ // TODO llevar límite carácteres a .env
                        $body[$key] = substr($value, 0, 200).'...';
                    }
                }
            }
            $body = json_encode($body);

            $type = 'INFO';
            $responseLog = $method !== 'GET' ? ' Response: '. $response : '';
            $message = '['.$type.']['.$_ENV['APP_NAME'].']['.$method.']: Url: '.$completeUrl.' Body: ' .$body.$responseLog;
            $this->logHelper->log($method, $statusCode, $_SERVER['REMOTE_ADDR'], $message, $type);
        }
    }
}
