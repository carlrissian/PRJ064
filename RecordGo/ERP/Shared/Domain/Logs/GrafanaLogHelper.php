<?php

namespace Shared\Domain\Logs;

class GrafanaLogHelper implements LogHelper
{

    public function log(string $method, int $status, string $ip, string $message, string $type): void
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $stream = [
            'cluster' => 'erp',
            'application' => $_ENV['APP_NAME'],
            'level' => strval($type),
            'status' => strval($status),
            'user' => $_SESSION['UserInfo']['completeName'] ?? '',
            'method' => $method,
            'environment' => strtoupper($_ENV['APP_ENV']),
            'country' => $_SESSION['UserInfo']['countryIso'] ?? 'none',
        ];

        $now = new \DateTime();
        // Time in microseconds
        $time = $now->getTimestamp() .  $now->format('u').'000';

        $values =[
            [
                $time,
                $message. ' - IP: ' . $ip
            ]
        ];
        $body['streams'][] = [
            'stream' => $stream,
            'values' => $values
        ];

        $this->sendLog(json_encode($body));

        // LOG SI HAY ERRORES EN PARAMETROS $method, $status, $ip, $message, $type
        $errorArray =  $this->validateLog($method, $status, $ip, $message, $type);
        if(count($errorArray) > 0){
            $this->log('GET', 500, $ip, json_encode($errorArray), 'INVALID_LOG');
        }
    }

    private function sendLog($body){
        $url = $_ENV['LOG_URL'];
        $username = $_ENV['LOG_USERNAME'];
        $password = $_ENV['LOG_PASSWORD'];


        $auth = base64_encode($username . ':' . $password);

        $header = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($body),
            'Authorization: Basic ' . $auth
        );

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

        try{
            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
            curl_close($ch);
        }catch (\Exception $e){
            error_log('Error sending log to Grafana: ' . $e->getMessage());
            return;
        }
    }

    private function validateLog(string $method, int $status, string $ip, string $message, string $type)
    {
        if ($type == 'INVALID_LOG') {
            return [];
        }
        $methodsAllowed = ['GET', 'POST', 'PATCH', 'DELETE'];
        $typesAllowed = ['ERROR', 'INFO', 'WARNING', 'INVALID_LOG'];
        $ipRegex = '/^([0-9]{1,3}\.){3}[0-9]{1,3}$/';

        $errorArray = [];

        if (!is_string($method) || !in_array($method, $methodsAllowed)) {
            $errorArray[] = 'method is not string or not allowed: ' . $method;
        }

        if (!is_int($status)) {
            $errorArray[] = 'status is not int: ' . $status;
        }

        if (!is_string($ip) || !preg_match($ipRegex, $ip)) {
            $errorArray[] = 'ip is not string or not valid: ' . $ip;
        }

        if (!is_string($message)) {
            $errorArray[] = 'message is not string: ' . $message;
        }

        if (!is_string($type) || !in_array($type, $typesAllowed)) {
            $errorArray[] = 'type is not string or not allowed: ' . $type;
        }

        return $errorArray;
    }

}