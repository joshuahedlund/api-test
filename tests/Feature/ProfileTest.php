<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function testCreateMissingRequired()
    {
        $response = $this->postJson('/profiles/create',[
            'first_name' => 'Test'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testCreateSuccess()
    {
        $response = $this->postJson('/profiles/create',[
            'first_name' => 'Test',
            'last_name' => 'Test'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['success','id']);
    }

    public function testShow()
    {
        $response = $this->get('/profile/1');

        $response->assertStatus(200)
            ->assertJsonStructure(['id','first_name','last_name']);
    }
}
