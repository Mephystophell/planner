<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShowEventController extends Controller
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
        $event = Event::query()->findOrFail($request->get('id'));

        return view('api.calendar.show', compact('user','event'));

    }
}
