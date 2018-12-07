<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateVideoRequest;
use App\Models\Playlist;
use App\Models\Video;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class VideosController extends Controller
{
    public static $menu = ['title' => 'videos.MENU_TITLE', 'route' => 'admin.videos.index', 'icon' => 'icon-social-youtube'];
    public static $breadcrumb = [['title' => 'playlists.BREADCRUMB_TITLE', 'route' => 'admin.playlists.index'], ['title' => 'videos.BREADCRUMB_TITLE']];

    public static $views = [
        'index' => 'admin.videos.index',
        'import' => 'admin.videos.import',
    ];

    public static $routes = [
        'index' => 'admin.playlists.videos',
        'store' => 'admin.playlists.videos.store',
        'delete' => 'admin.playlists.videos.delete',
        'import' => 'admin.playlists.videos.import',
        'back' => 'admin.playlists.index',
        'verify' => 'admin.playlists.videos.verify',
    ];

    private $playlist;

    public function __construct()
    {
        parent::__construct();
        $this->playlist = Playlist::find(request('playlist'));

        View::share('playlist', $this->playlist);
    }

    public function index()
    {
        $videos = $this->playlist->videos->paginate(env('MODEL_PAGINATE_SIZE', 20));

        return view(static::$views['index'], compact('videos'));
    }

    public function import()
    {
        return view(static::$views['import']);
    }

    public function store(CreateVideoRequest $request)
    {
        $data = $request->validated();

        $videos = $data['entry_type'] === Video::ENTRY_FILE ? $data['entry_file'] : explode(trim($data['entry_url']), "\r\n");

        foreach ($videos as $item) {
            $this->processVideo($item, $data['entry_type'] === Video::ENTRY_URL);
        }

        Session::flash('success', __('videos.IMPORT_SUCCESS'));

        return redirect()->route(static::$routes['index'], $this->playlist);
    }

    public function delete(Video $video)
    {
        $this->playlist = $video->playlists[0];
        $video->playlists()->detach();

        if ($video->entry_type === Video::ENTRY_FILE) {
            Storage::disk(Video::FILE_DISK)->delete($video->entry);
        }

        $video->delete();

        Session::flash('success', __('videos.DELETE_SUCCESS'));

        return redirect()->route(static::$routes['index'], $this->playlist);
    }

    protected function processVideo($item, $isURL = false)
    {
        $data = ['entry_type' => request()->get('entry_type')];
        if (!$isURL) {
            $success = preg_match('/sode\s+?(\d+)/', $item->getClientOriginalName(), $match);
            $ep = $success ? $match[1] : '0';

            $data = array_merge($data, [
                'title' => sprintf('%s Episode %s', $this->playlist->title, $ep),
                'entry' => $item->store(Video::FILE_FOLDER, Video::FILE_DISK),
                'verified' => true,
            ]);
        } else {
            $data = array_merge($data, [
                'title' => sprintf('$s - Timestamp $s', $this->playlist->title, Carbon::now()->getTimestamp()),
                'entry' => $item,
                'verified' => false,
            ]);
        }

        $video = (new Video())->fill($data);
        $video->save();

        Session::flash('success', __('videos.UPLOAD_SUCCESS', $data));

        if ($isURL) {
            Session::flash('warning', __('videos.UPLOAD_NOT_VERIFIED', $data));
        }

        $this->playlist->videos()->attach($video);
    }

    public function verify(Video $video)
    {
        $video->update(['verified' => true]);

        Session::flash('success', __('videos.UPLOAD_VERIFIED', [':video' => $video->title]));

        return redirect()->route(static::$routes['index'], $video->playlist);
    }
}
