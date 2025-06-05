<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

class Controller extends AbstractController
{

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $locale = \Locale::getDefault();
        $parameters['menus'] = Yaml::parseFile(__DIR__ . "/../../config/menus/menu.$locale.yaml");
        $parameters['user'] = $_SESSION['UserInfo'] ?? null;
        return parent::render($view, $parameters, $response);
    }
}