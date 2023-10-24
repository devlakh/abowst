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
        Schema::create('journal_extras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("academic_work_id")->unsigned()->index();
            $table->foreign("academic_work_id")->references("id")->on("academic_works")->onDelete("cascade");
            $table->boolean("published");
            $table->string("ISSN");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_extras');
    }
};
