<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class GenerateRoute extends Component
{
    public $content;
    public $routes = [];


    // extract route laravel 8 above format
    public function generateRouteList(): void
    {
        // validate request
        $this->validate([
            'content' => 'required'
        ]);
        // split the content by ;
        try {
            $list = explode(';', $this->content);
            // trim all routes and remove empty string
            $list = array_filter(array_map('trim', $list));
            $this->routes = [];
            foreach ($list as $route) {
                $route = explode('::', $route);
                $method = $route[0];
                $path = $route[1];
                $function = explode('@', explode('->', $path)[0])[1];
                $url = explode(',', explode('@', $path)[0])[0];
                $class = explode(',', explode('@', $path)[0])[1];
                // make route this format Route::get('get-question-check-temp', [CheckTempController::class, 'get_question_check_temp']);
                $name = $method . '::' . trim($url) . ', [\App\Http\Controllers\\' . trim(str_replace('\'', '', $class)) . '::class, \'' . trim(str_replace(')', '', $function)) . '])';
                if (isset(explode('->', $path)[1])) {
                    $name .= '->' . explode('->', $path)[1] > ';';
                } else {
                    $name .= ';';
                }
                $this->routes[] = $name;
            }
        } catch (\Exception $e) {
            $this->dispatch('error', 'Invalid route format');
        }
    }

    public function render(): View
    {
        return view('livewire.generate-route');
    }
}
