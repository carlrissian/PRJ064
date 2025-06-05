<?php

namespace App\Controller\Security;

use App\Controller\Controller;
use Shared\Domain\LoginHelper\LoginHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @var LoginHelper
     */
    private $loginHelper;

    public function __construct(LoginHelper $loginHelper)
    {
        $this->loginHelper = $loginHelper;
    }

    /**
     * Responsable de la autenticación
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request): Response
    {
        return $this->loginHelper->__invoke($request);
    }

    public function logout(): Response
    {
        session_destroy();
        return $this->redirectToRoute('app_login');
    }
}
