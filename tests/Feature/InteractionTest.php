<?php

namespace Tests\Feature;

use App\Models\Interaction;
use App\Models\Profile;
use Tests\TestCase;

class InteractionTest extends TestCase
{
    public function testCreateInvalidType(){
        $profile = Profile::all()->first();

        $response = $this->postJson(route('interaction.create', $profile->id), [
            'type' => 'invalid-value',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testCreateSuccess(){
        $profile = Profile::all()->first();

        $response = $this->postJson(route('interaction.create', $profile->id), [
            'type' => 'in-person'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id','success']);
    }

    public function testShow(){
        $interaction = Interaction::all()->first();
        $id = $interaction->id;

        $response = $this->get(route('interaction.show', $id));

        $response->assertStatus(200)
            ->assertJsonStructure(['profile_id','type','action_at']);
    }
}
