<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, LogsActivity;

    //Available status for an order
    const STATUS_CREATED = "CREATED";
    const STATUS_PAYED = "PAYED";
    const STATUS_REJECTED = "REJECTED";
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'status',
        'product_id',
        'identifier_code',
        'payment_url',
        'payment_session',
        'payment_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime:Y-m-d H:i:s',
    ];

     /**
      * this flag indicate to create log changes for all the $fillable attributes
      *
      * @var boolean
      */
    protected static $logFillable = true;

    /**
     * product
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function product(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
