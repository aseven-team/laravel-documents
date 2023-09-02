<?php

namespace AsevenTeam\Documents;

use Illuminate\Http\Response;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentFile
{
    public string $path;

    public function __construct(string $content)
    {
        $this->path = $this->createFilePath();

        file_put_contents($this->path, $content);
    }

    public function __destruct()
    {
        $this->delete();
    }

    protected function createFilePath(): string
    {
        $directory = sys_get_temp_dir();

        return $directory . '/' . uniqid('laravel_documents') . '.pdf';
    }

    public function download(): Response
    {
        return new Response($this->getContents(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.basename($this->path).'"'
        ]);
    }

    public function inline(): Response
    {
        return new Response($this->getContents(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($this->path).'"'
        ]);
    }

    public function stream(): StreamedResponse
    {
        return new StreamedResponse(function () {
            echo $this->getContents();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($this->path).'"'
        ]);
    }

    protected function getContents(): string
    {
        $contents = file_get_contents($this->path);

        if (! $contents) {
            throw new RuntimeException("Could not read file {$this->path}.");
        }

        return $contents;
    }

    public function delete(): void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }
}
