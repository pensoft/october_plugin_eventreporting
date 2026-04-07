<?php namespace Pensoft\EventReporting\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class EventsReportingAttendant extends Controller
{
    public $implement = [
        \Backend\Behaviors\ListController::class,
        \Backend\Behaviors\FormController::class,
    ];

    public string $listConfig = 'config_list.yaml';
    public string $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Pensoft.Eventreporting', 'main-menu-item', 'side-menu-item2');
    }
}