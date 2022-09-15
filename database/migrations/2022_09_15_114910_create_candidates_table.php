<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('name')->nullable();
            $table->string('education')->nullable();
            $table->date('date_of_birth');
            $table->string('experience')->nullable();
            $table->string('last_position')->nullable();
            $table->string('applied_position')->nullable();
            $table->text('top_skills')->nullable();
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('resume')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
