<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRoot()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testGraphqlWithoutToken()
    {
        $response = $this->get('/graphql');
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Authorization Token not found'
            ]);
    }

    public function testGraphqlWithInvalidToken()
    {
        //$response = $this->get('/graphql');
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. 'invalidtoken',
            //'Accept' => 'application/json'
        ])->get('/graphql');
        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Token is Invalid'
            ]);
    }
}
