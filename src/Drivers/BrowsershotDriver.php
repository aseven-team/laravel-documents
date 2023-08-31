<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use Spatie\Browsershot\Browsershot;

class BrowsershotDriver implements Driver
{
    public function render(string $html, array $options = []): string
    {
        return $this->applyOptions(Browsershot::html($html), $options)->pdf();
    }

    protected function applyOptions(Browsershot $shot, array $options): Browsershot
    {
        $pageSize = $options['page-size'] ?? 'A4';
        $orientation = $options['orientation'] ?? 'portrait';
        $marginTop = $options['margin-top'] ?? 19;
        $marginRight = $options['margin-right'] ?? 13.2;
        $marginBottom = $options['margin-bottom'] ?? 36.7;
        $marginLeft = $options['margin-left'] ?? 19;

        return $shot
            ->format($pageSize)
            ->landscape($orientation === 'landscape')
            ->margins($marginTop, $marginRight, $marginBottom, $marginLeft, 'mm');
    }
}
