<?php

namespace App\Http\Controllers\Admin;

use App\Models\Playlist;
use App\Http\Controllers\Controller;

class PlayerController extends Controller
{
    public static $menu = ['title' => 'Player', 'route' => 'admin.player.index', 'icon' => 'icon-calculator'];
    public static $breadcrumb = [['title' => 'Player', 'route' => 'admin.dashboard']];
    public static $views = ['index' => 'admin.player.index', 'view' => 'admin.player.view'];
    public static $routes = ['index' => 'admin.player.index'];

    public static function menu()
    {
        $playlists = Playlist::all();

        static::$menu = array_merge(static::$menu, [
            'dropdown' => $playlists
        ]);

        return static::$menu;
    }

    public function index(Playlist $playlist)
    {
        return view(static::$views['index'], compact('playlist'));
    }
}
