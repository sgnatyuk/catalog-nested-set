<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\Collection as NestedsetCollection;
use Kalnoy\Nestedset\QueryBuilder;

/**
 * @property int id;
 * @property int _lft;
 * @property int _rgt;
 * @property int parent_id;
 * @property string slug;
 * @property string title;
 * @property string content;
 * @property Carbon created_at;
 * @property Carbon updated_at;
 *
 * @property Collection|Product[] products;
 */
class Category extends Model
{
    use NodeTrait;

    protected $fillable = ['parent_id', 'slug', 'title', 'content'];

    public static function tree(): NestedsetCollection
    {
        /* @var QueryBuilder $query */
        $query = self::query()->withDepth();

        /* @var NestedsetCollection $collection */
        $collection = $query->defaultOrder()
            ->withCount('products')
            ->get();

        return $collection;
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
