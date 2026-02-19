<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Calculation;

class CalculationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_store_a_calculation(): void
    {
        $expression = '10 * 10';
        $result = 100;
        $payload = ['expression' => $expression];

        $response = $this->postJson('/api/calculations', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'expression' => $expression,
                'result' => $result,
            ]);
        $this->assertDatabaseHas('calculations', [
            'expression' => $expression,
            'result' => $result,
        ]);
    }

    public function test_it_validates_input_format(): void
    {
        $payload = ['expression' => '10 + abc'];

        $response = $this->postJson('/api/calculations', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function test_it_validates_required_fields(): void
    {
        $response = $this->postJson('/api/calculations', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['expression']);
    }

    public function test_it_can_list_history(): void
    {
        Calculation::factory()->create(['expression' => '1+1', 'result' => 2]);
        Calculation::factory()->create(['expression' => '2+2', 'result' => 4]);
        Calculation::factory()->create(['expression' => '3+3', 'result' => 6]);

        $response = $this->getJson('/api/calculations');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_it_can_delete_calculation(): void
    {
        $calc = Calculation::factory()->create(['expression' => '5+5', 'result' => 10]);

        $response = $this->deleteJson("/api/calculations/{$calc->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('calculations', ['id' => $calc->id]);
    }

    public function test_it_can_clear_all_history(): void
    {
        Calculation::factory()->create(['expression' => '1+1', 'result' => 2]);
        Calculation::factory()->create(['expression' => '2+2', 'result' => 4]);

        $response = $this->deleteJson("/api/calculations");

        $response->assertStatus(204);
        $this->assertDatabaseCount('calculations', 0);
    }
}
