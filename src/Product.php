<?php

namespace Jag\Dashboard;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, Sluggable;

    const CACHEKEY = 'product.';

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function tags()
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
