<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;


class StockRequest extends Model
{
    use HasFactory;
    public $table = 'stock_requests';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'team_id',
        'asset_id',
        'category_id',
        'created_at',
        'updated_at',
        'stock',
        'request',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');

    }
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');

    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');

    }
}
