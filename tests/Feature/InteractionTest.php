<?php

namespace Tests\Feature;

use Tests\TestCase;

class InteractionTest extends TestCase
{
    public function testCreateInvalidType(){
        $response = $this->postJson('/profile/1/create-interaction',[
            'type' => 'invalid-value',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testCreateSuccess(){
        $response = $this->postJson('/profile/1/create-interaction',[
            'type' => 'in-person'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id','success']);
    }

    public function testShow(){
        $response = $this->get('/interaction/1');

        $response->assertStatus(200)
            ->assertJsonStructure(['profile_id','type','action_at']);
    }
}
