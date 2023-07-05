<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class BrowserSessionManager extends Component
{
    public function getSessionsProperty(): Collection
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
            return (object) [
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
     */
    public function logoutSingleSessionDevice($session_id): void
    {
        if (config('session.driver') == 'database') {
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('id', $session_id)
                ->delete();
        }
    }

    /**
     * Log out from other browser sessions.
     */
    public function logoutOtherBrowserSessions(): void
    {
        $this->deleteOtherSessionRecords();
    }

    /**
     * Delete the other browser session records from storage.
     */
    protected function deleteOtherSessionRecords(): void
    {
        if (config('session.driver') == 'database') {
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', auth()->user()->getAuthIdentifier())
                ->where('id', '!=', request()->session()->getId())
                ->delete();
        }
    }

    /**
     * Create a new agent instance from the given session.
     */
    protected function createAgent(mixed $session): Agent
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }

    public function render(): View
    {
        return view('livewire.browser-session-manager')->layoutData([
            'title' => 'Browser Session Manager',
        ]);
    }
}
