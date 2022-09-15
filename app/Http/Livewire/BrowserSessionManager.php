<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jenssegers\Agent\Agent;

class BrowserSessionManager extends Component
{

    public function getSessionsProperty()
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }
        return collect(
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', auth()->user()->getAuthIdentifier())
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return (object)[
                'id' => $session->id,
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === request()->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }
    /**
     * Logout a session based on session id.
     *
     * @return void
     */
    public function logoutSingleSessionDevice($session_id)
    {
        if (config('session.driver') !== 'database') {
            return back();
        }

        DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('id', $session_id)
            ->delete();
    }

    /**
     * Log out from other browser sessions.
     *
     * @return void
     */
    public function logoutOtherBrowserSessions()
    {
        $this->deleteOtherSessionRecords();
    }


    /**
     * Delete the other browser session records from storage.
     *
     * @return void
     */
    protected function deleteOtherSessionRecords()
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))
            ->table(config('session.table', 'sessions'))
            ->where('user_id', auth()->user()->getAuthIdentifier())
            ->where('id', '!=', request()->session()->getId())
            ->delete();
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param mixed $session
     * @return Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }


    public function render()
    {
        return view('livewire.browser-session-manager');
    }
}
