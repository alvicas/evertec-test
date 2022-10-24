<?php

namespace App\Models;

use Illuminate\Support\Str;
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
    const CHECKOUT_STATUS_FAILED = "FAILED";
    const CHECKOUT_STATUS_OK = "OK";
    const PAYMENT_STATUS_PENDING = "PENDING";
    const PAYMENT_STATUS_APPROVED = "APPROVED";
    const PAYMENT_STATUS_REJECTED = "REJECTED";
    const PAYMENT_STATUS_ERROR = "ERROR";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_mobile',
        'customer_document_number',
        'customer_document_type',
        'status',
        'product_id',
        'identifier_code',
        'total',
        'payment_url',
        'payment_session',
        'payment_date',
        'payment_attempts',
        'payment_status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime:Y-m-d H:i:s',
        'total' => 'integer',
    ];

     /**
      * this flag indicate to create log changes for all the $fillable attributes
      *
      * @var boolean
      */
    protected static $logFillable = true;

    /**
     * setDataCreate
     *
     * @return array
     */
    public function createData(array $attributes): array
    {
        return [
            'customer_name' => $attributes['customer_name'],
            'customer_email' => $attributes['customer_email'],
            'customer_mobile' => $attributes['customer_mobile'],
            'customer_document_number' => $attributes['customer_document_number'],
            'customer_document_type' => $attributes['customer_document_type'],
            'product_id' => $attributes['product_id'],
            'identifier_code' => $this->getIdentifierCode(),
            'total' => $attributes['total'],
            'status' => Order::STATUS_CREATED,
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
        ];
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
     * getIdentifierCode
     *
     * @return string
     */
    public function getIdentifierCode(): string
    {
        $randomCode = Str::random(10);
        while ($this->where('identifier_code', $randomCode)->exists()) {
            $randomCode = Str::random(10);
        }
        return $randomCode;
    }
    
    /**
     * getCustomerFirstName
     *
     * @return string
     */
    public function getCustomerFirstName(): string
    {
        $splitName = explode(" ", $this->customer_name);
        return $splitName[0];
    }
    
    /**
    * Undocumented function
    *
    * @return void
    */
    public function getCustomerSurName()
    {
        $splitName = explode(" ", $this->customer_name);
        return isset($splitName[1]) ? $splitName[1] : null;
    }
    
    /**
    * getStatus function
    *
    * @return void
    */
    public function getStatus()
    {

        switch ($this->status) {
            case $this::STATUS_CREATED :
                $status = 'Creado';
                break;
            case $this::STATUS_PAYED :
                $status = 'Pagado';
                break;
            case $this::STATUS_REJECTED :
                $status = 'Pago Rechazado';
                break;
            default:
                $status = 'Creado';
                break;
        }

        return $status;
    }
    
    /**
    * getStatus function
    *
    * @return void
    */
    public function getPaymentStatus()
    {

        switch ($this->payment_status) {
            case $this::PAYMENT_STATUS_PENDING :
                $status = 'Pendiente';
                break;
            case $this::PAYMENT_STATUS_APPROVED :
                $status = 'Aprobado';
                break;
            case $this::PAYMENT_STATUS_REJECTED :
                $status = 'Rechazado';
                break;
            default:
                $status = 'Error en el pago';
                break;
        }

        return $status;
    }

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
