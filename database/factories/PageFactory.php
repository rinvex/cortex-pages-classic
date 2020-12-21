<?php

declare(strict_types=1);

namespace Cortex\Pages\Database\Factories;

use Cortex\Pages\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uri' => $this->faker->slug,
            'slug' => $this->faker->slug,
            'route' => $this->faker->slug,
            'title' => $this->faker->title,
            'view' => $this->faker->slug,
        ];
    }
}
