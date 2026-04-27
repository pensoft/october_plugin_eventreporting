<?php namespace Pensoft\EventReporting\Models;

use Model;
use Pensoft\Calendar\Models\Entry;
use RainLab\User\Models\User;

/**
 * Model
 */
class EventsreportingAttendants extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pensoft_eventreporting_attendants';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsTo = [
        'event' => Entry::class,
        'user' => User::class,
    ];
}