<?php


namespace App\WebModules\Video\Repositories;


use App\Modules\Video\Models\Video;

class VideoRepository
{
    public function getAll()
    {
        $videos = Video::with(['category'])->published()->get();

        return $videos;
    }
}