<?php

namespace App\Services\Api\V1;


use Carbon\Carbon;

class CalendarService
{

    public function serializeRequestData($request){

        $explodeData =  explode(" - ", $request->get('from_to'));
        $request['start_date'] = Carbon::parse($explodeData[0])->format('Y-m-d H:i:s');
        $request['end_date'] = Carbon::parse($explodeData[1])->format('Y-m-d H:i:s');

    }

}
