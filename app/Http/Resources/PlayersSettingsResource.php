<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlayersSettingsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if (blank($this->collection)) return [];

        $model = $this->collection->get(0);

        return [
            'id' => $model->id,
            'video' => [
                'id' => $model->video->id,
                'title' => $model->video->title,
                'entry' => $model->video->entry,
                'created_at' => $model->video->created_at->format('M d, Y H:i:s'),
                'updated_at' => $model->video->updated_at->format('M d, Y H:i:s'),
            ],
            'playlist' => [
                'id' => $model->video->playlist->id,
                'title' => $model->video->playlist->title,
                'created_at' => $model->video->playlist->created_at->format('M d, Y H:i:s'),
                'updated_at' => $model->video->playlist->updated_at->format('M d, Y H:i:s'),
            ],
            'video_time' => $model->video_time,
            'is_paused' => $model->is_paused,
            'created_at' => ($model->created_at ?? Carbon::now())->format('M d, Y H:i:s'),
            'updated_at' => ($model->updated_at ?? Carbon::now())->format('M d, Y H:i:s'),
        ];
    }
}
