<?php


namespace App\Services;

use DateTime;
use App\Models\Order;
use Illuminate\Http\Response;
use PhpParser\Node\Stmt\Return_;
use App\Traits\ConsumesExternalServices;
use Carbon\Carbon;

class OrderService
{
    use ConsumesExternalServices;
    /**
     * product
     *
     * @param Order $order
     */
    protected $order;
    
    /**
     * placetoplayUrlBase
     *
     * @var string
     */
    protected $placetoplayUrlBase;
    
    /**
     * placetoplayUrlBase
     *
     * @var string
     */
    protected $placetoplaySecretKey;
    
    /**
     * placetoplayUrlBase
     *
     * @var string
     */
    protected $placetoplayPortalId;

    /**
     * OrderService constructor
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->placetoplayPortalId = config("app.placetoplay_portal_id");
        $this->placetoplayUrlCheckout = config("app.placetoplay_url_checkout");
        $this->placetoplayUrlBase = config("app.placetoplay_url_base");
        $this->placetoplaySecretKey = config("app.placetoplay_secret_key");
    }
    
    /**
     * Undocumented function
     *
     * @param Order $order
     * @return void
     */
    public function createSessions(Order $order)
    {
        $this->order = $order;
        $body = $this->getBody();

        return $this->performRequest(
            'OrderService',
            'post',
            $this->placetoplayUrlCheckout,
            [],
            $body,
            [],
            false
        );
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getTranKey(): string
    {
        $seed = now()->format(DateTime::ISO8601);
        $tranKey = "$this->order->identifier_code.$seed.$this->placetoplaySecretKey";
        $sha = sha1($tranKey);
        
        return base64_encode($sha);
    }
    
    /**
     * getAuthData function
     *
     * @return array
     */
    public function getAuthData(): array
    {
        return  [
            'login' => $this->placetoplayPortalId,
            'tranKey' => $this->getTranKey(),
            'nonce' => base64_encode($this->order->identifier_code),
            'seed' => now()->format(DateTime::ISO8601)
        ];
    }
    
    /**
     * getAuthData function
     *
     * @return array
     */
    public function getUserData(): array
    {
        $firtName = $this->order->getCustomerFirstName();
        $surname = $this->order->getCustomerSurName();
        return  [
            'document' =>  $this->order->customer_document_number,
            'documentType' =>  $this->order->customer_document_type,
            'name' => $firtName,
            'surname' => $surname,
            'company' =>  "Evertec",
            'email' =>  $this->order->customer_email,
            'mobile' =>  $this->order->customer_mobile,
            'address' => [
                'street' => "Calle falsa 123",
                'city' => "Medellín",
                'state' => "Poblado",
                'postalCode' => "55555",
                'country' => "Colombia",
                'phone' => $this->order->customer_mobile,

            ]
        ];
    }
    
    /**
     * getBody function
     *
     * @return array
     */
    public function getBody(): array
    {

        return [
            'locale' => 'es_CO',
            'auth' => $this->getAuthData(),
            'payer' => $this->getUserData(),
            'buyer' => $this->getUserData(),
            "payment" => [
                'reference' => $this->order->identifier_code,
                'description' => "Prueba de pago",
                'amount' => [
                    'currency' => "COP",
                    'total' => $this->order->total,
                    'taxes' => [],
                    'details' => []
                ],
                'allowPartial' => false,
                'shipping' => $this->getUserData(),
                'items' => [
                    [
                        'sku' => $this->order->identifier_code,
                        'name' => $this->order->product->name,
                        'category' => "physical",
                        'qty' => "1",
                        'price' => $this->order->product->price,
                        'tax' => 0
                    ]
                ],
                'fields' => [],
                'recurring' => null,
                'subscribe' => false,
                'dispersion' => [
                    [
                        'agreement' => "1299",
                        'greementType' => "MERCHANT",
                        'amount' => [
                          'currency' => "USD",
                          'total' => 200
                        ]
                    ]
                ],
                'modifiers' => [
                    [
                        'type' => "FEDERAL_GOVERNMENT",
                        'code' => 17934,
                        'additional' => [
                            'invoice' => "123345"
                        ]
                    ]
                ]
            ],
            'subscription' => null,
            'fields' => [
                [
                    'keyword' => "_processUrl_",
                    'value' => "https://checkout.redirection.test/session/1/a592098e22acc709ec7eb30fc0973060",
                    'displayOn' => "none"
                ]
            ],
            'paymentMethod' => "visa",
            'expiration' => "2019-08-24T14:15:22Z",
            'returnUrl' => "https://commerce.test/return",
            'cancelUrl' => "https://commerce.test/cancel",
            'ipAddress' => "127.0.0.1",
            'userAgent' => "PlacetoPay Sandbox",
            'skipResult' => false,
            'noBuyerFill' => false,
            'type' => "checkin"
        ];
    }

    /**
     * Undocumented function
     *
     * @param Order $order
     * @param [type] $sessionPaymentRequest
     * @return void
     */
    public function updateOrderByPaymentRequest(Order $order, $sessionPaymentRequest)
    {
        if (
            $sessionPaymentRequest->status &&
            isset($sessionPaymentRequest->status->status)  &&
            $sessionPaymentRequest->status->status == Order::CHECKOUT_STATUS_OK
        ) {
            $dataToUpdate = [
                'payment_session' => json_encode($sessionPaymentRequest),
                'payment_url' => $sessionPaymentRequest->processUrl ?? null,
                'payment_date' => new Carbon($sessionPaymentRequest->status->date) ?? null,
                'payment_status' => Order::PAYMENT_STATUS_APPROVED,
            ];
        } else {
            $dataToUpdate = [
                'payment_session' => json_encode($sessionPaymentRequest),
                'payment_date' => $sessionPaymentRequest->status->status ?
                new Carbon($sessionPaymentRequest->status->date) : null,
                'payment_status' => Order::PAYMENT_STATUS_ERROR,
            ];
        }

        $order->update($dataToUpdate);
    }
}