<?php


namespace Shared\Domain\Mailer\Render;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Error_Syntax;

class TwigRenderer implements RendererInterface
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * TwigRenderer constructor.
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $template
     * @param array $data
     * @return RenderedEmail
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Syntax
     */
    public function render(string $template, array $data): RenderedEmail
    {
        $data = $this->twig->mergeGlobals($data);
        $template = $this->twig->loadTemplate($template);
        $subject = $template->renderBlock("subject", $data);
        $body = $template->renderBlock("body", $data);
        return new RenderedEmail($subject, $body);
    }
}