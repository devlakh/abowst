<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_works', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("title");
            $table->date("date");
            $table->string("publication")->nullable();
            $table->string("department");
            $table->text("description");
            $table->mediumText("abstract");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_works');
    }
};
