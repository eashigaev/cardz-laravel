<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collect_achievements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('company_id')->index();
            $table->foreignUuid('program_id')->index();
            $table->foreignUuid('task_id')->index();
            $table->foreignUuid('card_id')->index();
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
        Schema::dropIfExists('collect_achievements');
    }
}
