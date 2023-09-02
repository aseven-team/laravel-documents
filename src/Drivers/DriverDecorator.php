<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use AsevenTeam\Documents\Models\DocumentFile;
use AsevenTeam\Documents\Models\DocumentTemplate;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;

class DriverDecorator implements Driver
{
    public function __construct(
        protected Driver $driver,
        protected string $diskName,
    ) {
    }

    public function create(DocumentTemplate $template, array $variables = [], array $options = []): DocumentFile
    {
        if (is_array($template->variables)) {
            $variables = array_merge($template->variables, $variables);
        }

        if (is_array($template->options)) {
            $options = array_merge($template->options, $options);
        }

        $html = $this->renderTemplate($template, $variables);

        $pdf = $this->render($html, $options);

        $filePath = $this->save($pdf);

        $size = $this->getFileSize($filePath);

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
        $pdf = $this->render($html, $options);

        $filePath = $this->save($pdf);

        $size = $this->getFileSize($filePath);

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

    protected function save(string $content): string
    {
        $path = $this->getDestinationPath();

        if (! $this->getDisk()->put($path, $content)) {
            throw new RuntimeException("Disk [{$this->diskName}] cannot be accessed.");
        }

        return $path;
    }

    protected function getFileSize(string $path): int
    {
        return $this->getDisk()->size($path);
    }

    protected function getDestinationPath(): string
    {
        $filename = Str::random(40);

        return date('Y/m/').'documents/'.$filename.'.pdf';
    }

    protected function getDisk(): Filesystem
    {
        if (is_null(config("filesystems.disks.{$this->diskName}"))) {
            throw new InvalidArgumentException("There is no filesystem disk named [{$this->diskName}].");
        }

        return Storage::disk($this->diskName);
    }

    public function render(string $html, array $options = []): string
    {
        return $this->driver->render($html, $options);
    }
}
