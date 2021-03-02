<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OAuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Get all the request parameters
        $input = $request->all();
        // Attempt to load the venue from the state we set in $client->setState($venue->id);
        $venue = Venue::findOrFail($input['state']);
        // If the user cancels the process then they should be send back to
        // the venue with a message.
        if (isset($input['error']) &&  $input['error'] == 'access_denied') {
            \Session::flash('global-error', 'Authentication was cancelled. Your calendar has not been integrated.');
            return redirect()->route('venues.show', ['slug' => $venue->slug]);
        } elseif (isset($input['code'])) {
            // Else we have an auth code we can use to generate an access token
            // This is the helper we added to setup the Google Client with our             
            // application settings
            $gcHelper = new GoogleCalendarHelper($venue);
            // This helper method calls fetchAccessTokenWithAuthCode() provided by 
            // the Google Client and returns the access and refresh tokens or 
            // throws an exception
            $accessToken = $gcHelper->getAccessTokenFromAuthCode($input['code']);
            // We store the access and refresh tokens against the venue and set the 
            // integration to active.
            $venue->update([
                'gcalendar_credentials' => json_encode($accessToken),
                'gcalendar_integration_active' => true,
            ]);
            \Session::flash('global-success', 'Google Calendar integration enabled.');
            return redirect()->route('venues.show', ['slug' => $venue->slug]);
        }
    }
}
