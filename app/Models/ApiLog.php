<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = ['user_id','method', 'path', 'request_payload', 'response_preview',
     'status_code','user_agent','ip','duration_ms','full_url','ip'];

     protected $casts = [
        'request_payload' => 'array',
        'duration_ms'=>'float',
        'created_at'=>'datetime'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeSlowRequest($query, $threshold = 1000)
    {
        return $query->where('duration_ms', '>', $threshold);
    }

    public function scopeFailedRequest($query)
    {
        return $query->where('status_code', '>=', 400);
    }


}
