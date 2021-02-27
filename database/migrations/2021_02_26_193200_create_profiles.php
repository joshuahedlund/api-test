<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function(Blueprint $table){
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address')->nullable();
            $table->string('apt')->nullable();
            $table->string('city')->nullable();
            $table->string('state',2)->nullable();
            $table->string('zip',10)->nullable();
            $table->string('phone',16)->nullable();
            $table->string('mobile',16)->nullable();
            $table->string('email')->nullable();
            $table->string('address_geo')->nullable();

            $table->index('first_name');
            $table->index('last_name');
            $table->index('email');

            $table->timestamps();
        });

        Schema::create('interactions', function(Blueprint $table){
            $table->increments('id');

            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('profiles');

            $table->enum('type',['in-person','email','phone','sms'])->default('in-person');
            $table->timestamp('action_at');
            $table->string('address_geo')->nullable();
            $table->enum('outcome',['contacted','not home','no answer','no response'])->default('contacted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interactions');
        Schema::dropIfExists('profiles');
    }
}
