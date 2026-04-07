<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftEventreportingData extends Migration
{
    public function up(): void
    {
        Schema::table('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->string('slug');
        });
    }

    public function down(): void
    {
        Schema::table('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->dropColumn('slug');
        });
    }
}