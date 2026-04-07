<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftEventreportingData6 extends Migration
{
    public function up(): void
    {
        Schema::table('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->dropColumn('name');
            $table->dropColumn('surname');
            $table->dropColumn('affiliation');
            $table->dropColumn('email');
        });
    }

    public function down(): void
    {
        Schema::table('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->string('name', 255);
            $table->string('surname', 255);
            $table->string('affiliation', 255);
            $table->string('email', 255);
        });
    }
}