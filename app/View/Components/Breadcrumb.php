<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Route;

class Breadcrumb extends Component
{
    public $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = $this->generateBreadcrumbs();
    }

    public function render()
    {
        return view('components.breadcrumb');
    }

    private function generateBreadcrumbs()
    {
        $breadcrumbs = collect([]);
        $route = Route::current();
        $routeSegments = explode('/', $route->uri());

        $url = '';
        foreach ($routeSegments as $segment) {
            $url .= '/' . $segment;
            $breadcrumbs->push((object)[
                'url' => $url,
                'title' => ucfirst($segment),
            ]);
        }

        return $breadcrumbs;
    }
}
