<?php

namespace App\Modules\Reservation\Models;

use App\Modules\Partners\Models\Partner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeAllInActive($query)
    {
        $now = Carbon::now();
        return $query->where('end_date', '<', $now);
    }

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }
}
