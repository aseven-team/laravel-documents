<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use AsevenTeam\Documents\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;
use Illuminate\Support\Facades\Blade;
use InvalidArgumentException;

class DriverDecorator implements Driver
{
    public function __construct(
        protected Driver $driver,
    ) {
    }

    public function create(string $templateKey, array $variables = [], array $options = []): DocumentFile
    {
        $template = $this->getTemplate($templateKey);

        if (is_array($template->variables)) {
            $variables = array_merge($template->variables, $variables);
        }

        if (is_array($template->options)) {
            $options = array_merge($template->options, $options);
        }

        $html = $this->renderTemplate($template, $variables);

        $pdf = $this->render($html, $options);

        return new DocumentFile($pdf);
    }

    public function createFromHtml(string $html, array $options = []): DocumentFile
    {
        $pdf = $this->render($html, $options);

        return new DocumentFile($pdf);
    }

    protected function renderTemplate(DocumentTemplate $template, array $variables): string
    {
        return Blade::render($template->content, $variables, true);
    }

    public function render(string $html, array $options = []): string
    {
        return $this->driver->render($html, $options);
    }

    protected function getTemplate(string $templateKey): DocumentTemplate
    {
        $template = DocumentTemplate::where('key', $templateKey)->first();

        if (is_null($template)) {
            throw new InvalidArgumentException("Document template with key [{$templateKey}] not found.");
        }

        return $template;
    }
}
