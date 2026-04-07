<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePensoftEventreportingAttendants extends Migration
{
    public function up(): void
    {
        Schema::create('pensoft_eventreporting_attendants', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('event_id');
            $table->integer('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pensoft_eventreporting_attendants');
    }
}