<?php

namespace Tests\Feature;

use App\Models\Interaction;
use App\Models\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function testProfileCreateMissingRequired()
    {
        $response = $this->postJson(route('profile.create'), [
            'first_name' => 'Test'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testProfileCreateSuccess()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test'
        ];

        $response = $this->postJson(route('profile.create'), $data);

        $this->assertDatabaseHas('profiles',$data);
    }

    public function testProfileShow()
    {
        $profile = Profile::where('first_name','test')->where('last_name','test')->first();
        $id = $profile->id;

        $response = $this->get(route('profile.show',$id));

        $response->assertStatus(200)
            ->assertJsonStructure(['id','first_name','last_name']);
    }

    public function testInteractionCreateInvalidType(){
        $profile = Profile::where('first_name','test')->where('last_name','test')->first();

        $response = $this->postJson(route('interaction.create', $profile->id), [
            'type' => 'invalid-value',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testInteractionCreateSuccess(){
        $profile = Profile::where('first_name','test')->where('last_name','test')->first();

        $response = $this->postJson(route('interaction.create', $profile->id), [
            'type' => 'in-person'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id','success']);
    }

    public function testInteractionShow(){
        $interaction = Interaction::all()->first();
        $id = $interaction->id;

        $response = $this->get(route('interaction.show', $id));

        $response->assertStatus(200)
            ->assertJsonStructure(['profile_id','type','action_at']);
    }

    public function testProfileList()
    {
        $response = $this->get(route('profile.index'));

        $response->assertStatus(200)
            ->assertJsonStructure(['total','page','profiles']);
    }

    public function testProfileListWithInteractions()
    {
        $response = $this->get(route('profile.index', ['includeInteractions' => 1]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'page',
                'profiles' =>
                    ['0' => ['interactions']]
            ]);
    }

    public function testProfileUpdateMissingRequired()
    {
        $profile = Profile::where('first_name','test')->where('last_name','test')->first();
        $id = $profile->id;

        $data = [
            'first_name' => null,
            'last_name' => 'Tester'
        ];

        $response = $this->postJson(route('profile.update',$id), $data);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testProfileUpdateSuccess()
    {
        $profile = Profile::where('first_name','Test')->where('last_name','Test')->first();
        $id = $profile->id;

        $data = [
            'first_name' => 'Tester',
            'last_name' => 'Tester'
        ];

        $response = $this->postJson(route('profile.update',$id), $data);

        $this->assertDatabaseHas('profiles', $data);
    }

    public function testProfileDeleteSuccess()
    {
        $profile = Profile::where('first_name','Tester')->where('last_name','Tester')->first();
        $id = $profile->id;

        $response = $this->postJson(route('profile.delete',$id));

        $profile = Profile::find($id);

        $this->assertEmpty($profile);
    }
}
