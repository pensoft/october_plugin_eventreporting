<?php namespace Pensoft\EventReporting\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePensoftEventreportingData5 extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pensoft_eventreporting_data', 'event_start')) {
            Schema::table('pensoft_eventreporting_data', function (Blueprint $table) {
                $table->dateTime('event_start')->useCurrent();
                $table->string('website', 255)->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pensoft_eventreporting_data', 'event_start')) {
            Schema::table('pensoft_eventreporting_data', function (Blueprint $table) {
                $table->dropColumn('event_start');
                $table->string('website', 255)->nullable(false)->change();
            });
        }
    }

}