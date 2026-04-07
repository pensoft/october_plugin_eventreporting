<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftEventreportingData4 extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pensoft_eventreporting_data', 'event_end')) {
            Schema::table('pensoft_eventreporting_data', function (Blueprint $table) {
                $table->dateTime('event_end')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pensoft_eventreporting_data', 'event_end')) {
            Schema::table('pensoft_eventreporting_data', function (Blueprint $table) {
                $table->dropColumn('event_end');
            });
        }
    }
}