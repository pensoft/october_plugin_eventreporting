<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftEventreportingData3 extends Migration
{
    public function up(): void
    {
        Schema::table('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->dateTime('event_end')->nullable(false)->unsigned(false)->default(null)->comment(null);
            $table->dateTime('event_date')->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
            $table->string('website', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pensoft_eventreporting_data', function(Blueprint $table)
        {
            $table->dropColumn('event_end');
            $table->date('event_date')->nullable(false)->unsigned(false)->default(null)->comment(null)->change();
            $table->string('website', 255)->nullable(false)->change();
        });
    }
}