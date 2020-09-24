<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Modules\Room\Models\Room;
use App\Modules\Room\Requests\RoomStoreRequest;
use App\Modules\Room\Requests\RoomUpdateRequest;
use App\Modules\Room\Requests\DestroySelectedRequest;
use App\Modules\Room\UseCases\RoomUseCase;

class RoomController extends Controller
{
    private $roomUseCase;

    public function __construct(RoomUseCase $roomUseCase)
    {
        $this->roomUseCase = $roomUseCase;
    }

    public function getAll()
    {
        $rooms = Room::all();

        return compact('rooms');
    }

    public function store(RoomStoreRequest $request)
    {
        $room = $this->roomUseCase->create($request);

        return compact('room');
    }

    public function update(RoomUpdateRequest $request, $roomId)
    {
        $room = $this->roomUseCase->update($request, $roomId);

        return compact('room');
    }

    public function destroy($roomId)
    {
        $this->roomUseCase->destroy($roomId);

        return response()->json('success', 200);
    }

    public function destroySelected(DestroySelectedRequest $selectedRequest)
    {
        $this->roomUseCase->destroySelected($selectedRequest);

        return response()->json('success', 200);
    }
}
