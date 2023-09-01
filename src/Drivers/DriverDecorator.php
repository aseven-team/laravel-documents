<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use AsevenTeam\Documents\Contract\HasDocuments;
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

    public function create(
        HasDocuments $model,
        DocumentTemplate $template,
        array $variables = [],
        array $options = [],
        string $documentType = null,
    ): DocumentFile {
        $variables = array_merge($template->variables, $variables);
        $options = array_merge($template->options, $options);

        $filePath = $this->renderTemplate($template, $variables, $options);

        $size = Storage::fileSize($filePath);

        return $model->documents()->create([
            'document_template_id' => $template->id,
            'document_type' => $documentType,
            'path' => $filePath,
            'size' => $size,
            'variables' => $variables,
            'options' => $options,
        ]);
    }

    public function createFromHtml(
        HasDocuments $model,
        string $html,
        array $options = [],
        string $documentType = null,
    ): DocumentFile {
        $filePath = $this->renderHtml($html, $options);

        $size = Storage::fileSize($filePath);

        return $model->documents()->create([
            'document_type' => $documentType,
            'path' => $filePath,
            'size' => $size,
            'options' => $options,
        ]);
    }

    protected function renderTemplate(DocumentTemplate $template, array $variables, array $options): string
    {
        $html = Blade::render($template->content, $variables, true);

        return $this->renderHtml($html, $options);
    }

    protected function renderHtml(string $html, array $options): string
    {
        $pdfContent = $this->render($html, $options);

        return $this->savePdf($pdfContent);
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
