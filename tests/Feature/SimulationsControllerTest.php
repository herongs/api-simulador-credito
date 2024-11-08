<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Log;

class SimulationsControllerTest extends TestCase
{
    public function testStoreReturnsCreatedResponse()
    {
        $requestData = [
            'birth_date' => '2000-11-26',
            'loan_amount' => 10000,
            'payment_date' => 12,
        ];

        $response = $this->postJson('/api/simulacao-credito', $requestData);

        $response->assertStatus(201);
        $response->assertJson(['message' => __('messages.created')]);
    }

}
