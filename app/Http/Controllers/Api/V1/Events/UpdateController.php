<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Events\UpdateEventRequest;
use App\Http\Resources\Api\V1\Events\UpdateResource;
use App\Models\Event;
use App\Services\Api\V1\CalendarService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UpdateController extends Controller
{

    public function __invoke(UpdateEventRequest $request)
    {

        if (!Gate::allows('event_update')) {
            return abort(401);
        }

        try
        {

            $user = Auth::user();
            $event = Event::findOrFail($request->get('id'));
            (new CalendarService())->serializeRequestData($request);
            $request['user_id'] = $user->id;
            $event->update($request->all());

            return new UpdateResource($event);

        }catch(QueryException $ex) {
            return ['success'=>false, 'error'=>$ex->getMessage()];
        }

    }
}
