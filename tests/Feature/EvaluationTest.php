<?php

namespace Tests\Feature;

use App\Models\Evaluation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class EvaluationTest extends TestCase
{
    use WithFaker;

    /**
     * Test Evaluation Empty.
     *
     * @return void
     */
    public function test_get_evaluation_empty()
    {

        $uuid = 'fake-uuid';

        $response = $this->getJson("/evaluations/{$uuid}");

        // $response->dump();

        $response->assertStatus(200)
            ->assertJsonCount(0, 'data');
    }

    /**
     * Get Evaluation from Company.
     *
     * @return void
     */
    public function test_get_evaluations_from_company()
    {

        $company = Str::uuid();

        Evaluation::factory()->count(6)->create([
            'company' => $company,
        ]);

        $response = $this->getJson("/evaluations/{$company}");

        // $response->dump();

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data');
    }

    /**
     * Store Evaluation Error.
     *
     * @return void
     */
    public function test_error_store_evaluation()
    {

        $company = "fake-company";

        $response = $this->postJson("/evaluations/{$company}", []);

        // $response->dump();

        $response->assertStatus(422);
    }

    /**
     * Store Evaluation.
     *
     * @return void
     */
    public function test_store_evaluation()
    {

        $company = "fake-company";

        $response = $this->postJson("/evaluations/{$company}", [
            'company' => Str::uuid(),
            'comment' => $this->faker->sentence(10),
            'stars' => random_int(1, 5),
        ]);

        // $response->dump();

        $response->assertStatus(404);
    }
}
