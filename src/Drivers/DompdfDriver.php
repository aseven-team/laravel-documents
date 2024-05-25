<?php

namespace AsevenTeam\Documents\Drivers;

use AsevenTeam\Documents\Contract\Driver;
use Barryvdh\DomPDF\Facade\Pdf;

class DompdfDriver implements Driver
{
    public function render(string $html, array $options = []): string
    {
        return Pdf::loadHTML($html)
            ->setPaper($options['page-size'] ?? 'a4', $options['orientation'] ?? 'portrait')
            ->output();
    }
}
