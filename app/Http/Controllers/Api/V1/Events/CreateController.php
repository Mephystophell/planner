<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Events\StoreEventRequest;
use App\Http\Resources\Api\V1\Events\StoreResource;
use App\Models\Event;
use App\Services\Api\V1\CalendarService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreEventRequest $request)
    {

        if (!Gate::allows('event_create')) {
            return abort(401);
        }

        (new CalendarService())->serializeRequestData($request);
        $event = Event::create($request->all());

        return new StoreResource($event);

    }


}
