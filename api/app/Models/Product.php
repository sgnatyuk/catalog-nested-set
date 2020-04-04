<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id;
 * @property int category_id;
 * @property int image_id;
 * @property string slug;
 * @property string title;
 * @property string content;
 * @property Carbon created_at;
 * @property Carbon updated_at;
 *
 * @property Category category;
 * @property Image image;
 */
class Product extends Model
{
    protected $fillable = ['category_id', 'image_id', 'slug', 'title', 'content'];

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function image()
    {
        return $this->belongsTo(Image::class)->withDefault();
    }
}
