<?php

namespace Database\Seeders;

use App\Models\Interaction;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $profile = new Profile();
       $profile->first_name = 'Bilbo';
       $profile->last_name = 'Baggins';
       $profile->city = 'Saint Louis';
       $profile->state = 'MO';
       $profile->zip = '63101';
       $profile->save();

       $interaction = new Interaction();
       $interaction->profile_id = $profile->id;
       $interaction->type = 'in-person';
       $interaction->action_at = date( 'Y-m-d H:i:s',time());
       $interaction->outcome = 'contacted';
       $interaction->save();

       $profile = new Profile();
       $profile->first_name = 'Frodo';
       $profile->last_name = 'Baggins';
       $profile->city = 'Beverly Hills';
       $profile->state = 'CA';
       $profile->zip = '90210';
       $profile->save();
    }
}
