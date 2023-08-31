<?php

namespace AsevenTeam\Documents\Contract;

interface Driver
{
    /**
     * Render HTML to PDF and return temporary file path of the rendered PDF.
     */
    public function render(string $html, array $options = []): string;
}
