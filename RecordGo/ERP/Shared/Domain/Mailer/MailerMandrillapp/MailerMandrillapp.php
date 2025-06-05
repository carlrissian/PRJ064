<?php


namespace Shared\Domain\Mailer\MailerMandrillapp;


use Shared\Domain\Mailer\MailerInterface;

class MailerMandrillapp implements MailerInterface
{
    /**
     * @var string
     * Clave de la API de Mandrillapp
     */
    private $key;
    /**
     * @var string
     * Url de envío de correos de MandrillApp
     */
    private $sendUrl;

    /**
     * Configurar fichero .env con siguientes variables:
     * MANDRILLAPP_KEY=clave de la API de Mandrillapp
     * MANDRILLAPP_SEND_URL=url de envío de correos de MandrillApp
     */
    public function __construct()
    {
        $this->key = $_ENV['MANDRILLAPP_KEY'];
        $this->sendUrl = $_ENV['MANDRILLAPP_SEND_URL'];
    }

    /**
     * @param array $to
     * Array destinatarios. Ejemplo: [['email' => 'mostrador@recordrentacar.com', 'name' => 'Mostrador Record Rent a Car'], ['email' => 'dnr@recordrentacar.com', 'name' => 'DNR Record Rent a Car']]
     * @param string $subject
     * @param array $images
     * Array de imágenes a incrustar en el correo. Ejemplo: [['path' => '/../../public/images/logo.png', 'name' => 'logo']]
     * @param array $atachment
     * Array adjuntos. Ejemplo: [['type' => 'application/pdf', 'name' => 'factura.pdf', 'content' => base64_encode(file_get_contents($path))]]
     * @param string $body
     * @param string|null $from
     * @param string|null $fromName
     * @return int
     */
    public function send(
        array $to,
        string $subject,
        array $images,
        array $atachment,
        string $body,
        ?string $from = null,
        ?string $fromName = null
    ): int {
        $from = ($from === null || $from === '') ? 'no-reply@recordrentacar.com' : $from;
        $formNameByDefault = isset($_ENV['APP_ENV']) && $_ENV['APP_ENV'] !== 'production' ? $_ENV['APP_NAME'].' - Record go Mobility' : 'Record go Mobility';
        $fromName = ($fromName === null || $fromName === '') ? $formNameByDefault : $fromName;


        $message = array(
            'text' => $body,
            'html' => $body,
            'subject' => $subject,
            'from_email' => $from,
            'from_name' => $fromName,
            'to' => $to,
            'headers' => array('Reply-To' => $from),
            'important' => false,
            'track_opens' => null,
            'track_clicks' => null,
            'auto_text' => null,
            'auto_html' => null,
            'inline_css' => null,
            'url_strip_qs' => null,
            'preserve_recipients' => null,
            'view_content_link' => null,
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
            'merge' => true
        );

        $message['attachments'] = $atachment;
        $message['images'] = $images;

        $params = array(
            "message" => $message,
            "key" => $this->key,
            "async" => false,
            "ip_pool" => null,
            "send_at" => null
        );

        $params = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mandrill-PHP/1.0.52');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        curl_setopt($ch, CURLOPT_URL, $this->sendUrl . '.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, false);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $result = json_decode($result);

        // TODO si se registran nuevos errores, crear su control de excepción
        if (is_array($result) && count($result) < 2) {
            switch ($result[0]->status) {
                case 'rejected':
                    $httpCode = 400;
                    break;
            }
        }

        return $httpCode;
    }
}
