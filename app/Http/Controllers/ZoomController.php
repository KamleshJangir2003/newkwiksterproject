<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ZoomSetting;

class ZoomController extends Controller
{
    public function index()
    {
        $settings = ZoomSetting::first();
        $recordings = [];

        if ($settings) {
            $token = $this->getZoomToken($settings);

            if ($token) {
                $response = Http::withToken($token)
                    ->get("https://api.zoom.us/v2/accounts/{$settings->account_id}/recordings");

                $recordings = $response->json()['meetings'] ?? [];
            }
        }

        return view('admin.zoom', compact('recordings'));
    }

    // ✅ NEW METHOD ADDED (THIS WAS MISSING)
    public function createMeeting(Request $request)
    {
        // Temporary fake Zoom ID (later we can replace with real Zoom API)
        $meetingId = 'ZM-' . rand(100000000, 999999999);

        return redirect()->route('admin_zoom')
            ->with('meeting_id', $meetingId)
            ->with('meeting_title', $request->title);
    }

    private function getZoomToken($settings)
    {
        $res = Http::asForm()->post("https://zoom.us/oauth/token", [
            'grant_type' => 'account_credentials',
            'account_id' => $settings->account_id,
            'client_id' => $settings->client_id,
            'client_secret' => $settings->client_secret,
        ]);

        return $res->json()['access_token'] ?? null;
    }
}
