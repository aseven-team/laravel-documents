<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use AsevenTeam\Documents\Models\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DriverDecorator implements Driver
{
    public function __construct(
        protected Driver $driver,
    ) {
    }

    public function create(DocumentTemplate $template, array $variables = [], array $options = []): DocumentFile
    {
        $variables = array_merge($template->variables, $variables);
        $options = array_merge($template->options, $options);

        $html = $this->renderTemplate($template, $variables);

        $pdfContent = $this->render($html, $options);

        $filePath = $this->savePdf($pdfContent);

        $size = Storage::fileSize($filePath);

        return DocumentFile::create([
            'document_template_id' => $template->id,
            'path' => $filePath,
            'size' => $size,
            'content' => $html,
            'variables' => $variables,
            'options' => $options,
        ]);
    }

    public function createFromHtml(string $html, array $options = []): DocumentFile
    {
        $pdfContent = $this->render($html, $options);

        $filePath = $this->savePdf($pdfContent);

        $size = Storage::fileSize($filePath);

        return DocumentFile::create([
            'path' => $filePath,
            'size' => $size,
            'content' => $html,
            'options' => $options,
        ]);
    }

    protected function renderTemplate(DocumentTemplate $template, array $variables): string
    {
        return Blade::render($template->content, $variables, true);
    }

    protected function savePdf(string $pdfContent): string
    {
        $filename = Str::random(40);
        $path = date('Y/m/').'documents/'.$filename.'.pdf';

        Storage::put($path, $pdfContent, ['visibility' => 'public']);

        return $path;
    }

    public function render(string $html, array $options = []): string
    {
        return $this->driver->render($html, $options);
    }
}
