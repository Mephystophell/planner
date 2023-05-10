<?php

namespace App\Http\Controllers\Api\V1\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DeleteController extends Controller
{

    public function __invoke(Request $request)
    {

        if (! Gate::allows('event_delete')) {
            return abort(401);
        }

        $event = Event::findOrFail($request->get('id'));
        $event->forceDelete();

        $response = http_response_code();
        return response()->json(['status_code' => $response]);

    }
}
