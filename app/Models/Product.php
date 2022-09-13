<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'summary',
        'price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'double',
    ];

    /**
     * log changes to all the $fillable attributes
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    protected static $logFillable = true;
    
    /**
     * product
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Order::class);
    }
}
