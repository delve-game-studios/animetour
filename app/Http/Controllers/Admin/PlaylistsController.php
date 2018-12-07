<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PlaylistsController extends Controller
{
    public static $menu = ['title' => 'playlists.MENU_TITLE', 'route' => 'admin.playlists.index', 'icon' => 'icon-playlist'];
    public static $breadcrumb = [['title' => 'playlists.BREADCRUMB_TITLE', 'route' => 'admin.playlists.index']];

    public static $views = [
        'index' => 'admin.playlists.index',
        'create' => 'admin.playlists.create',
        'edit' => 'admin.playlists.edit'
    ];

    public static $routes = [
        'index' => 'admin.playlists.index',
        'create' => 'admin.playlists.create',
        'edit' => 'admin.playlists.edit',
        'store' => 'admin.playlists.store',
        'update' => 'admin.playlists.update',
        'delete' => 'admin.playlists.delete',
        'attach-videos' => 'admin.playlists.videos'
    ];

    public function index()
    {
        $playlists = Playlist::paginate();

        return view(static::$views['index'], compact('playlists'));
    }

    public function create()
    {
        return view(static::$views['create']);
    }

    public function store(CreatePlaylistRequest $request)
    {
        $data = $request->validated();

        (new Playlist())->fill($data)->save();

        return redirect()->route(static::$routes['index'])->withSuccess(__('playlists.CREATE_SUCCESS'));
    }

    public function edit(Playlist $playlist)
    {
        return view(static::$views['edit'], compact('playlist'));
    }

    public function update(UpdatePlaylistRequest $request, Playlist $playlist)
    {
        $playlist->update($request->validated());

        return redirect()->route(static::$routes['edit'])->withSuccess(__('playlists.UPDATE_SUCCESS'));
    }

    public function delete(Playlist $playlist)
    {
        foreach($playlist->videos as $video) {
            if ($video->entry_type === Video::ENTRY_FILE) {
                Storage::disk(Video::FILE_DISK)->delete($video->entry);
            }

            request()->request->add(['viaPlaylist' => true]);

            $video->playlists()->detach();
            $video->delete();
        }

        $playlist->delete();

        return redirect()->route(static::$routes['index'])->withSuccess(__('playlists.DELETE_SUCCESS'));
    }
}
