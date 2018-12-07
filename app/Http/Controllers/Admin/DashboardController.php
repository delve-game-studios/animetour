<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public static $menu = ['title' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'icon-speedometer'];
    public static $breadcrumb = [['title' => 'Dashboard', 'route' => 'admin.dashboard']];
    public static $views = ['index' => 'admin.dashboard.index'];
    public static $routes = ['index' => 'admin.dashboard'];

    public function index()
    {
        return view(static::$views['index']);
    }
}
