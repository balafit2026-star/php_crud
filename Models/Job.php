<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'Jobs';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    protected $fillable = [
        'Title'
    ];
}