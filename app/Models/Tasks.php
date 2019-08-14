<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable=['theme','message', 'user_id', 'files', 'created_at', 'ansver'];
    public $timestamps = false;
}
