<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['id', 'name', 'description', 'price', 'quantity', 'category_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = \Ramsey\Uuid\Uuid::uuid4()->toString();
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
