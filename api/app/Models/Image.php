<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id;
 * @property string name;
 * @property boolean use;
 */
class Image extends Model
{
    protected $fillable = ['name', 'use'];
}
