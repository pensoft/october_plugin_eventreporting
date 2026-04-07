<?php namespace Pensoft\EventReporting\Components;

use Auth;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Cms\Classes\Theme;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use October\Rain\Exception\ValidationException;
use October\Rain\Support\Facades\Flash;
use Pensoft\Calendar\Models\Entry;
use Pensoft\EventReporting\Models\EventsreportingAttendants;
use Pensoft\EventReporting\Models\EventsreportingData;

/**
 * EventReportingForm Component
 */
class EventReportingForm extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'EventReportingForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties(): array
    {
        return [];
    }

    public function onRun()
    {
        $this->addCss('assets/css/style.css');
        $this->addJs('assets/js/jquery-ui-timepicker-addon.js');
        $this->page['slug'] = $this->param('slug');

        $user = Auth::getUser();
        if($user){
            $theme = Theme::getActiveTheme();
            $this->page['user'] = $user;
            $this->page['project_name'] = $theme->site_name;

        }else{
            return Redirect::to('/');
        }
        if($this->param('slug')){
            $event = Entry::where('christophheich_calendar_entries.slug', $this->param('slug'))
                ->leftJoin('pensoft_eventreporting_data', 'christophheich_calendar_entries.slug', '=', 'pensoft_eventreporting_data.slug')
                ->first();
            $this->page['event'] = $event;
        }

    }

    public function onSubmit()
    {
        $user = Auth::getUser();

        if(!$user->id){
            return Redirect::to('/');
        }
        $validator = Validator::make(
            $form = request()->all(), [
                'user_id' => 'required',
                'event_name' => 'required',
                'event_start' => 'required',
                'event_end' => 'required',
                'organiser' => 'required',
                'project_organised' => 'required',
                'venue' => 'required',
                'online_hybrid_onsite' => 'required',
                'is_internal' => 'required',
            ]
        );

        if($validator->fails()){
            throw new ValidationException($validator);
        }

        $dateStart = request()->get('event_start');
        $dateStart = str_replace('/', '-', $dateStart);
        $dateEnd = request()->get('event_end');
        $dateEnd = str_replace('/', '-', $dateEnd);

        $user_id = request()->get('user_id');
        $event_name = request()->get('event_name');
        $event_slug = Str::slug($event_name, "-");
        $event_date = Carbon::parse($dateStart)->format('Y-m-d H:i:s');
        $event_start = Carbon::parse($dateStart)->format('Y-m-d H:i:s');
        $event_end = Carbon::parse($dateEnd)->format('Y-m-d H:i:s');
        $organiser = request()->get('organiser');
        $project_organised = (int)request()->get('project_organised');
        $venue = request()->get('venue');
        $online_hybrid_onsite = (int)request()->get('online_hybrid_onsite');
        $website = request()->get('website');
        $is_internal = request()->get('is_internal');

        $slug = request()->get('slug');
        $internalEventId = request()->get('internal_event_id');

        if($slug != '' && (int)$internalEventId){
            $eventReport = EventsreportingData::where('id', (int)$internalEventId)->first();
            $entry = Entry::where('slug', $slug)->first();
        }else{
            $eventReport = new EventsreportingData();

        }

        $eventReport->event_name = $event_name;
        $eventReport->slug = $event_slug;
        $eventReport->event_date = $event_date;
        $eventReport->event_start = $event_start;
        $eventReport->event_end = $event_end;
        $eventReport->organiser = $organiser;
        $eventReport->project_organised = $project_organised;
        $eventReport->venue = $venue;
        $eventReport->online_hybrid_onsite = $online_hybrid_onsite;
        $eventReport->website = $website;
        $eventReport->is_internal = $is_internal;
        $eventReport->save();




//        $event_date_to_compare = Carbon::parse($dateStart)->format('Y-m-d');
//        ----
        $entrySlug = $slug ?: null;
        if(!$entrySlug){
            $entry = new Entry();
        }else{
            $entry = Entry::where('slug', $entrySlug)->first();
        }

        $entry->title = $event_name;
        $entry->slug = $event_slug;
        $entry->start = $event_start;
        $entry->end = $event_end;
        $entry->all_day = false;
        $entry->identifier = $project_organised;
        $entry->url = $website;
        $entry->place = $venue;
        $entry->show_on_timeline = false;
        $entry->is_internal = $is_internal;
        $entry->description = '';
        $entry->save();

        $eventAttentant = EventsreportingAttendants::where('event_id', $entry->id)->first();
        if(!$eventAttentant){
            $eventAttentant = new EventsreportingAttendants();
        }
        $eventAttentant->event_id = $entry->id;
        $eventAttentant->user_id = $user_id;
        $eventAttentant->save();

        Flash::success('Thank you!');
        return Redirect::to('/event-attendance-planner-success');
    }
}