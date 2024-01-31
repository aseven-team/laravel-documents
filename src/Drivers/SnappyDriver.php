<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use Barryvdh\Snappy\Facades\SnappyPdf;

class SnappyDriver implements Driver
{
    public function render(string $html, array $options = []): string
    {
        return SnappyPdf::loadHTML($html)
            ->setPaper($options['page-size'] ?? 'A4')
            ->setOrientation($options['orientation'] ?? 'portrait')
            ->setOptions([
                'margin-top' => $options['margin-top'] ?? 19,
                'margin-right' => $options['margin-right'] ?? 13.2,
                'margin-bottom' => $options['margin-bottom'] ?? 36.7,
                'margin-left' => $options['margin-left'] ?? 19,
                'enable-local-file-access' => true,
            ])
            ->output();
    }
}
