<?php namespace Pensoft\EventReporting;

use Pensoft\EventReporting\Components\Calendar;
use Pensoft\EventReporting\Components\EventAttendanceForm;
use Pensoft\EventReporting\Components\EventReportingForm;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    /**
     * @var array Plugin dependencies
     */
    public $require = [
        'pensoft.calendar'
    ];

    public function registerComponents(): array
    {
        return [
            EventReportingForm::class => 'EventReportingForm',
            EventAttendanceForm::class => 'EventAttendanceForm',
            Calendar::class => 'Calendar',
        ];
    }

    public function registerSettings(): array
    {
        return [];
    }
}