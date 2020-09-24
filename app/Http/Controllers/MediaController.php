<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function getImage($path)
    {
        return Storage::get("images/".$path);
    }

    public function excel()
    {
        $csv = Storage::get("file.csv");

        return $csv;
    }

}