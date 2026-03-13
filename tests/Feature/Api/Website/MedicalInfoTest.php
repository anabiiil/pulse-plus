<?php

namespace Tests\Feature\Api\Website;

use Tests\TestCase;

class MedicalInfoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
