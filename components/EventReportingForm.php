<?php namespace Pensoft\EventReporting\Components;

use Auth;
use Carbon\Carbon;
use Cms\Classes\ComponentBase;
use Cms\Classes\Theme;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use October\Rain\Exception\ValidationException;
use October\Rain\Support\Facades\Flash;
use Pensoft\Calendar\Models\Entry;
use Pensoft\EventReporting\Models\EventsreportingAttendants;
use Pensoft\EventReporting\Models\EventsreportingData;
use Pensoft\Partners\Models\Partners;

/**
 * EventReportingForm Component
 */
class EventReportingForm extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'EventReportingForm Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun(){
        $this->addCss('assets/css/style.css');

        $user = Auth::getUser();
        if($user){
            $theme = Theme::getActiveTheme();
            $partner = Partners::where('id', $user->partner_id)->first();
            $this->page['user'] = $user;
            $this->page['project_name'] = $theme->site_name;
            $this->page['partner'] = $partner->instituion;
        }else{
            return Redirect::to('/');
        }

    }

    public function onSubmit(){
        $user = Auth::getUser();

        if(!$user->id){
            return Redirect::to('/');
        }
        $validator = Validator::make(
            $form = \Input::all(), [
                'user_id' => 'required',
                'event_name' => 'required',
                'event_start' => 'required',
                'event_end' => 'required',
                'organiser' => 'required',
                'project_organised' => 'required',
                'venue' => 'required',
                'online_hybrid_onsite' => 'required',
            ]
        );

        if($validator->fails()){
            throw new ValidationException($validator);
        }
        
        $dateStart = \Input::get('event_start');
        $dateStart = str_replace('/', '-', $dateStart);
        $dateEnd = \Input::get('event_end');
        $dateEnd = str_replace('/', '-', $dateEnd);

        $user_id = \Input::get('user_id');
        $event_name = \Input::get('event_name');
        $event_slug = str_slug($event_name , "-");
        $event_date = Carbon::parse($dateStart)->addHours(1)->format('Y-m-d H:i:s');
        $event_start = Carbon::parse($dateStart)->addHours(1)->format('Y-m-d H:i:s');
        $event_end = Carbon::parse($dateEnd)->addHours(2)->format('Y-m-d H:i:s');
        $organiser = \Input::get('organiser');
        $project_organised = (int)\Input::get('project_organised');
        $venue = \Input::get('venue');
        $online_hybrid_onsite = (int)\Input::get('online_hybrid_onsite');
        $website = \Input::get('website');

        $eventReport = new EventsreportingData();
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
        $eventReport->save();

        $eventAttentant = new EventsreportingAttendants();
        $eventAttentant->event_id = $eventReport->id;
        $eventAttentant->user_id = $user_id;
        $eventAttentant->save();

        $event_date_to_compare = Carbon::parse($dateStart)->format('Y-m-d');
//        ----
        $entrySlug = Entry::where('title', $event_slug)->whereDate('start', '=', $event_date_to_compare)->first();
        if(!$entrySlug){
            $entry = new Entry();
            $entry->title = $event_name;
            $entry->slug = $event_slug;
            $entry->start = $event_start;
            $entry->end = $event_end;
            $entry->all_day = false;
            $entry->identifier = $project_organised;
            $entry->url = $website;
            $entry->place = $venue;
            $entry->show_on_timeline = false;
            $entry->is_internal = false;
            $entry->description = '';
            $entry->save();
        }

        Flash::success('Thank you!');
        return \Redirect::to('/event-attendance-planner-success');
    }
}
