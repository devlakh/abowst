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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("academic_work_id")->unsigned()->index();
            $table->foreign("academic_work_id")->references("id")->on("academic_works")->onDelete("cascade");
            $table->string("pre_fix")->nullable();
            $table->string("given_name");
            $table->string("middle_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("suffix")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authors');
    }
};
