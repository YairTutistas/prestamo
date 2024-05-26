<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Clients;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clients>
 */
class ClientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Clients::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'addresses' => $this->faker->address,
            'type_document' => $this->faker->randomElement(['Cedula ciudadania', 'Tarjeta identidad', 'Cedula extranjeria', 'Pasaporte']), // Selecciona aleatoriamente entre los tipos de documentos
            'document' => $this->faker->unique()->numberBetween(100000000000, 999999999999), // Número de documento único de 8 dígitos
            // otras columnas de la tabla clients si las hay
        ];
    }
}
