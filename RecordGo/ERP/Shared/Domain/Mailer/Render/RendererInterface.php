<?php

namespace Shared\Domain\Mailer\Render;

interface RendererInterface
{
    public function render(string $template, array $data): RenderedEmail;
}