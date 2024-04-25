<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Society;
use App\Models\Venue;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth('user_api')->user();
        $eventsCount = Event::where('status', 1)->count();
        $societiesCount = Society::where('status', 1)->count();
        $upcomingEventsCount = Event::where('status', 1)
        ->where('date_time', '>', now())
            ->count();

        if($request->latitude && $request->longitude && $request->distance)
        {
            $nearByVenues  = Venue::isWithinMaxDistance($request->latitude, $request->longitude, 'km',$request->distance)->limit(7)->get();
        }
        else{
            $nearByVenues  = Venue::orderBy('created_at', 'desc')->limit(7)->get();
        }
            
        $upcomingEvents = Event::where('status', 1)
            ->where('date_time', '>', now())
            ->with('media' , 'venue')
            ->get();

        foreach ($upcomingEvents as $event) {
            $event->has_joined_society = $event->userHasJoined($user->id);
        }

        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => [
                'eventsCount' => $eventsCount,
                'societiesCount' => $societiesCount,
                'upcomingEventsCount' => $upcomingEventsCount,
                'upcomingEvents' => $upcomingEvents,
                'nearByVenues' => $nearByVenues,
            ]
        ]);
    }
}
