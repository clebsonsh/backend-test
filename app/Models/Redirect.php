<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Redirect extends Model
{
    const STATUS_ACTIVE = 'active';

    const STATUS_INACTIVE = 'inactive';

    use HasFactory, SoftDeletes;

    public function resolveRouteBinding($code, $field = null)
    {
        return $this->where('id', Hashids::decode($code))->first() ?? abort(404, 'Redirect not found');
    }

    public $fillable = ['status', 'url', 'last_accessed_at'];

    public $casts = [
        'last_accessed_at' => 'datetime',
    ];

    public $appends = ['code'];

    public function getCodeAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function isActive()
    {
        return $this->status === $this::STATUS_ACTIVE;
    }

    public function logs()
    {
        return $this->hasMany(RedirectLog::class);
    }
}
