<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendenceSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendencesettings', function (Blueprint $table) {
            $table->increments('id');
            $table->time('total_work_hour');
            $table->time('arrival_time');
            $table->string('cron_time');
            $table->time('check_out_fixed');
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
        Schema::dropIfExists('attendencesettings');
    }
}
