<?php

namespace AsevenTeam\Documents\Contract;

interface Driver
{
    /**
     * Render HTML to PDF and return temporary file path of the rendered PDF.
     *
     * @param string $html
     * @param array $options
     * @return string
     */
    public function render(string $html, array $options = []): string;
}
