<?php

namespace Tests\Feature;

use App\Models\Profile;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function testCreateMissingRequired()
    {
        $response = $this->postJson(route('profile.create'), [
            'first_name' => 'Test'
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure(['errors']);
    }

    public function testCreateSuccess()
    {
        $data = [
            'first_name' => 'Test',
            'last_name' => 'Test'
        ];

        $response = $this->postJson(route('profile.create'), $data);

        $this->assertDatabaseHas('profiles',$data);
    }

    public function testShow()
    {
        $profile = Profile::where('first_name','test')->where('last_name','test')->first();
        $id = $profile->id;

        $response = $this->get(route('profile.show',$id));

        $response->assertStatus(200)
            ->assertJsonStructure(['id','first_name','last_name']);
    }

    public function testList()
    {
        $response = $this->get(route('profile.index'));

        $response->assertStatus(200)
            ->assertJsonStructure(['total','page','profiles']);
    }

    public function testListWithInteractions()
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

    public function testUpdateMissingRequired()
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

    public function testUpdateSuccess()
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

    public function testDeleteSuccess()
    {
        $profile = Profile::where('first_name','Tester')->where('last_name','Tester')->first();
        $id = $profile->id;

        $response = $this->postJson(route('profile.delete',$id));

        $profile = Profile::find($id);

        $this->assertEmpty($profile);
    }
}
