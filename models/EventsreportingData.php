<?php namespace Pensoft\EventReporting\Models;

use Carbon\Carbon;
use Model;

/**
 * Model
 */
class EventsreportingData extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'pensoft_eventreporting_data';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * Get the formatted values of our eloquent model.
     *
     */
    public static function formatted()
    {
        $entries = EventsreportingData::whereNull('deleted_at')->get()->toArray();

        return array_map(function($data) {
            $format['id']               = $data['id'];
            $format['title']            = $data['event_name'];
            $format['slug']             = $data['slug'];
                $format['start']        = $data['event_start'];
                $format['end']          = $data['event_end'];

            $format['color']            = null;
            $format['textColor']        = null;
            $format['rendering']        = null;
            $format['description']      = "";
            if(!empty($data['website'])) {
                $format['url']          = $data['website'];
            }
            $format['allDay']           = false;
            $format['displayEventEnd']  = null;
            $format['displayEventTime'] = null;
            $format['eventTitle']            = $data['event_name'];
            $format['index']               = null;
            $format['timeFormat']       = null;
            $format['overlap']          = null;
            $format['className']        = null;
            $format['editable']         = null;
            $format['startEditable']    = null;
            $format['durationEditable'] = null;
            $format['resourceEditable'] = null;
            $format['source']           = null;


            return $format;

        }, $entries);
    }
}