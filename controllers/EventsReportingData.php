<?php namespace Pensoft\EventReporting\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class EventsReportingData extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    /**
     * @var string formConfig file
     */
    public string $formConfig = 'config_form.yaml';

    /**
     * @var string listConfig file
     */
    public string $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Pensoft.Eventreporting', 'main-menu-item', 'side-menu-item');
    }
}