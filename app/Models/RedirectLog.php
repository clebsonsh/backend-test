<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedirectLog extends Model
{
    use HasFactory;

    public $fillable = ['redirect_id', 'ip_address', 'user_agent', 'referer', 'query_params'];

    public function redirect()
    {
        return $this->belongsTo(Redirect::class);
    }
}
