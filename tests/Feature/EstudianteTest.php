<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Paralelo;
use App\Models\Estudiante;

class EstudianteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $paralelo = Paralelo::factory()->create();
        //$response = $this->get('/');
        $response = $this->postJson('/api/estudiantes',[
            'nombre' => 'Carlos Perez',
            'cedula' => '1234567890',
            'correo' => 'carlos@example.com',
            'paralelo_id' => $paralelo->id,
        ]);
        $response->assertStatus(201)
                 ->assertJsonFragment(['mensaje' => 'Estudiante creado correctamente']);
        $this->assertDatabaseHas('estudiantes', [
            'cedula' => '1234567890',
            'correo' => 'carlos@example.com',
        ]);
        
    }
}
