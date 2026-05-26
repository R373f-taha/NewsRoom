<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{ use HasFactory;
    protected $guarded = [];

    // App\Models\Article.php

    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
 ];

    public function attachable(){

        return $this->morphTo();
    }
}
