<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Vinkla\Hashids\Facades\Hashids;

class Redirect extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['status', 'url', 'last_accessed_at'];

    public $appends = ['code'];

    public function getCodeAttribute()
    {
        return Hashids::encode($this->id);
    }

    public function logs()
    {
        return $this->hasMany(RedirectLog::class);
    }
}
