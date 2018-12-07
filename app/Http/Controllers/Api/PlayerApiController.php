<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PlayersSettingsResource;
use App\Models\PlayersSetting;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlayerApiController extends Controller
{
    public function index(User $user)
    {
        $playersSettings = PlayersSetting::where('user_id', '=', $user->id)->get();
        return new PlayersSettingsResource($playersSettings);
    }
}
