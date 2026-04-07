<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePensoftEventreportingData extends Migration
{
    public function up(): void
    {
        Schema::create('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('affiliation');
            $table->string('email');
            $table->string('event_name');
            $table->dateTime('event_date');
            $table->string('organiser');
            $table->smallInteger('project_organised')->default(1);
            $table->string('venue')->nullable();
            $table->smallInteger('online_hybrid_onsite')->default(1);
            $table->string('website');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pensoft_eventreporting_data');
    }
}