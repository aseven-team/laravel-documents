<?php

namespace AsevenTeam\Documents\Database\Factories;

use AsevenTeam\Documents\Models\DocumentTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentTemplateFactory extends Factory
{
    protected $model = DocumentTemplate::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->word(),
            'name' => $this->faker->name(),
            'content' => $this->faker->word(),
            'variables' => [],
            'options' => [],
        ];
    }
}
