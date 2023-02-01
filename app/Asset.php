<?php

namespace App;

use \DateTimeInterface;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model implements HasMedia
{
    use SoftDeletes, HasFactory,InteractsWithMedia;

    public $table = 'assets';
    const Measurement = [
        'meter',
        'cenmeter',
        'feet',
        'quantity',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'category_id',
        'type',
        'status',
        'unit',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'danger_level',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'asset_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');

    }
}
