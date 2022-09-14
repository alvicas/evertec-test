<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, LogsActivity;

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
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function get(int $id)
    {
        return $this::find($id);
    }
    
    
    /**
     * getProductsPaginated
     *
     * @return void
     */
    public function getProductsPaginated()
    {
        return $this::paginate(10);
    }

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
