<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\PlaylistsController;
use App\Http\Controllers\Admin\VideosController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static $routes = [];
    public static $breadcrumb = [];
    public static $menu = [];

    public function __construct()
    {
        View::share('version', file_get_contents(base_path('version')));
        View::share('routes', static::$routes);
        View::share('breadcrumb', static::$breadcrumb);
        View::share('adminMenu', static::adminMenu());
    }

    protected function addToBreadcrumb($item)
    {
        $breadcrumb = View::shared('breadcrumb');
        array_push($breadcrumb, $item);
        View::share('breadcrumb', $breadcrumb);
    }

    public static function adminMenu()
    {
        return [
            DashboardController::$menu,
            PlaylistsController::$menu,
            PlayerController::menu(),
//            VideosController::$menu,
        ];
    }

    protected function dropdown($item)
    {
        static::$menu = array_merge(static::$menu, ['dropdown' => $item]);
    }
}
