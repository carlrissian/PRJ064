<?php

namespace Shared\Domain\LoginHelper;

use App\Controller\Controller;
use Shared\Domain\Logs\LogHelper;
use Shared\LoginCountry\Domain\LoginCountryRepositoryInterface;
use Shared\Utils\MenuTopCreator\MenuTopCreator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gestión de inicio de sesión en todos los satélites
 */
class LoginHelper extends Controller
{
    /**
     * @var LogHelper
     */
    private LogHelper $logHelper;

    /**
     * @var LoginCountryRepositoryInterface
     */
    private LoginCountryRepositoryInterface $loginCountryRepository;

    /**
     * @param LogHelper $logHelper
     * @param LoginCountryRepositoryInterface $loginCountryRepository
     */
    public function __construct(LogHelper $logHelper, LoginCountryRepositoryInterface $loginCountryRepository)
    {
        $this->logHelper = $logHelper;
        $this->loginCountryRepository = $loginCountryRepository;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $username = $request->get('_username');
        $password = $request->get('_password');
        $country = $request->get('_countryId');
        $error = null;

        if ($username && $password && $country) {
            $userToken = $this->getAuthToken($username, $password, $country);

            // Usuario autenticado, redirigir
            if ($userToken['sapSessionId'] !== null && $userToken['authenticated'] === true) {

                if(  isset( $_SESSION['redirectUrl'] ) && $_SESSION['redirectUrl']  ) {
                    $redirectUri = $_SESSION['redirectUrl'];
                    $_SESSION['redirectUrl'] = null;
                    return $this->redirect($redirectUri );
                }

                return $this->redirectToRoute('index');
            }

            $messageByCode = [
                201 => 'You are not allowed to access in this country',
                401 => 'Incorrect username or password',
                400 => 'Bad request',
                500 => 'Internal server error'
            ];

            // Usuario no autenticado, mostrar error
            $error = [
                'messageData' =>  $messageByCode[$userToken['code']] ?? 'Unexpected error',
            ];
            $message = '[ERROR]['.$_ENV['APP_NAME'].'][LOGIN]: '.json_encode(['username' => $username, 'country' => $country, 'message' => $userToken]);
            $this->logHelper->log('POST', $userToken['code'], '', $message, 'ERROR');
        }

        $countryList = $this->loginCountryRepository->getAll();
        $countryArray = [];
        foreach ($countryList as $country) {
            $countryArray[] = [
                'iso' => $country->getIso(),
                'name' => $country->getName()
            ];
        }

        return $this->render('security/login.html.twig', ['countryList' => $countryArray, 'last_username' => $username, 'error' => $error]);
    }

    /**
     * Realiza petición de autenticación a SAP
     *
     * @param string $username
     * @param string $password
     * @param string $country
     * @return void
     */
    private function getAuthToken(string $username, string $password, string $country): array
    {

        $loginUrl =  $_ENV['SAP_LOGIN_URL'];

        $params = ['user' => $username, 'password' => $password, 'country_id' => $country];
        $payload = json_encode($params);

        $ch = curl_init($loginUrl);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,  CURLOPT_HEADER,  true);
        $result = curl_exec($ch);

        $error = curl_error($ch);
        $info = curl_getinfo($ch);

        $code = $info['http_code'] ?? null;

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($result, $header_size);

        curl_close($ch);

        $resultArray = json_decode($body, true);

        $sapSessionId = null;
        if ($resultArray && isset($resultArray['authenticated']) && $resultArray['authenticated'] === true) {
            preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);

            $userInfo = $this->getUserInfo($resultArray);

            if ( $userInfo['accessLevel'] == 1 ||
               ( $userInfo['accessLevel'] == 2 && $userInfo['internalCountryCode'] == $userInfo['internalCustomerCountryCode'] ) ) {

                $now = new \DateTime();
                $_SESSION["NextSapSessionId"] = $now->getTimestamp() + $_ENV['SAP_TOKEN_LIMIT_MINUTES'] * 60;
                $_SESSION["SapSessionId"] = $matches[1][0];
                $_SESSION["UserId"] = $resultArray['ID'];
                $_SESSION["UserInfo"] = $userInfo;

                $sapSessionId = $_SESSION["SapSessionId"];
            } else {
                $resultArray['authenticated'] = false;
                $code = 201;
                $resultArray['message'] = 'No tiene permisos para acceder a este país';
            }
        }

        $authenticated = $resultArray['authenticated'] ?? false;
        $message = $resultArray['message'] ?? null;

        return ['sapSessionId' => $sapSessionId , 'authenticated' => $authenticated ,'message' => $message, 'code' => $code ];

    }

    /**
     * @param array $user
     * @return array
     */
    private function getUserInfo(array $user): array
    {
        $menuTop = new MenuTopCreator();

        if (isset($user['adUsr']['givenName'])) {
            $name = $user['adUsr']['givenName'];
        } else {
            $nameLdap = explode('.', $user['user']);
            $name = ucfirst($nameLdap[0]);
        }

        //Sacamos el timezone según el país de logueo
        $timezone = null;
        $internalCode = null;
        $countryList = $this->loginCountryRepository->getAll();
        foreach ($countryList as $country) {
            if($country->getIso() == $user['COUNTRY_ID']){
                $timezone = $country->getTimezone();
                $internalCode = $country->getInternalCode();
            }
        }

        $internalCustomerCountryCode = 0;
        $internalEmployeeId = 0;
        if ( isset ( $user['adUsr']['employeeID'] ) ) {
            $employeeInfo = explode("-", $user['adUsr']['employeeID'] );
            $internalCustomerCountryCode = isset($employeeInfo[0]) ? $employeeInfo[0] : 0;
            $internalEmployeeId = isset($employeeInfo[1]) ? $employeeInfo[1] : 0;
        }

        return array_merge( [
            'username' => $user['user'],
            'id' => $user['ID'],
            'name' => $name,
            'completeName' => $user['adUsr']['displayName'],
            'countryIso' => $user['COUNTRY_ID'],
            'timezone' => $timezone,
            'internalCountryCode' => $internalCode,
            'internalCustomerCountryCode' => $internalCustomerCountryCode,
            'internalEmployeeId' => $internalEmployeeId,
            'accessLevel'=> $user['adUsr']['MOSYAccessLevel']
        ], $menuTop->getInfoMenu($user));
    }
}
