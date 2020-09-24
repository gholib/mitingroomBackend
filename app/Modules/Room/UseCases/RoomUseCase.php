<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/23/2020
 * Time: 1:07 PM
 */

namespace App\Modules\Room\UseCases;


use App\Modules\Room\Models\Room;

class RoomUseCase
{
    public function create($request)
    {
        $imgPath = $request->file('img')->store('images');

        $room = Room::create([
            'title' => $request->title,
            'img' => $imgPath
        ]);

        return $room;
    }

    public function update($request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        $room->title = $request->title;
        if($request->file('img')){
            $imgPath = $request->file('img')->store('images');
            $room->img = $imgPath;
        }

        $room->update();

        return $room;
    }

    public function destroy($roomId):void
    {
        $room = Room::findOrFail($roomId);

        $room->delete();
    }

    public function destroySelected($selectedRequest):void
    {
        foreach ($selectedRequest->selected as $id) {
            $room = Room::find($id);
            $room->delete();
        }
    }
}