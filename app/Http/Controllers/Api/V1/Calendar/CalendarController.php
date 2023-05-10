<?php

namespace App\Http\Controllers\Api\V1\Calendar;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CalendarController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        if (! Gate::allows('show_calendar')) {
            return abort(401);
        }

        $user = Auth::user();
        $events = Event::query()->where('user_id',$user->id)->get();

        $jsEvents = [];
        foreach ($events as $event){
            $jsEvents[] = [
                'id' => $event->id,
                'title' => $event->name,
                'start' => Carbon::parse($event->start_date)->format('Y-m-d'),
                'end' => Carbon::parse($event->end_date)->format('Y-m-d'),
            ];
        }

        return view('api.calendar.index',compact('user','events', 'jsEvents'));

    }
    public function showEvent(){
        $event = 'aaa';
        return view('api.calendar.show', compact('event'));
    }
}
