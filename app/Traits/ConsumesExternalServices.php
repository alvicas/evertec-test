<?php


namespace App\Traits;

use Exception;
use GuzzleHttp\Client;
use Spatie\Activitylog\Traits\LogsActivity;

trait ConsumesExternalServices
{
    use LogsActivity;
    
    /**
     * headers
     *
     * @var array
     */
    private $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];


    /**
     * parameters
     *
     * @var array
     */
    private $parameters = [];
    
    /**
     * client
     *
     * @var Client
     */
    private $client;


    /**
     * ProductIndexController constructor
     *
     * @param Product $product
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $serviceName
     * @param string $method
     * @param string $url
     * @param bool $saveLogSuccess
     * @param array $headers
     * @param array $body
     * @param array $auth
     * @param bool $verify
     * @return mixed|null
     */
    public function performRequest(
        string $serviceName,
        string $method,
        string $url,
        array $headersData = [],
        array $body = [],
        array $auth = [],
        bool $verify = true
    )
    {
        $method = strtoupper($method);
        $this->setParameters($method, $headersData, $body, $auth, $verify);
        try {
            $response = $this->client->request($method, $url, $this->parameters);
            $responseContent = json_decode($response->getBody()->getContents(), true);
            
            activity()
            ->withProperties([
                'request' => json_encode($this->parameters),
                'response' => $response->getBody()->getContents()
            ])
            ->log("request success from $serviceName");
            
            return $responseContent;
        } catch (Exception $exception) {

            activity()
            ->withProperties([
                'request' => json_encode($this->parameters),
                'response' => $exception->getMessage()
            ])
            ->log("request error from $serviceName");

            return $exception;
        }
    }


    /**
     * setParameters
     * 
     * Define the parameters of a request
     *
     * @param string $method
     * @param array $headers
     * @param array $body
     * @param array $auth
     * @param boolean $verify
     * @return array
     */
    private function setParameters(
        string $method, 
        array $headersData = [],
        array $body = [],
        array $auth = [],
        bool $verify = true
    ): array
    {
        $method = strtoupper($method);

        $this->setAuthData($auth, $verify);
        $this->setHeaderData($headersData);
        $this->setBodyData($body, $method);

        return $this->parameters;
    }
    

    /**
     * setAuthData
     *
     * @param array $auth
     * @param boolean $verify
     * @return void
     */
    private function setAuthData(array $auth, bool $verify): void
    {
        if (!empty($auth)) {
            $this->parameters["auth"] = $auth;
            $this->parameters["verify"] = $verify;
        }
    }
    
    /**
     * setHeaderData
     *
     * @param array $headers
     * @return void
     */
    private function setHeaderData(array $headersData): void
    {
        $this->parameters["headers"] = !empty($headersData) ? $headersData : $this->headers;
    }
    
    /**
     * setBodyData
     *
     * @param array $body
     * @param string $method
     * @return void
     */
    private function setBodyData(array $body, string $method): void
    {
        if (!empty($body) && ($method != "GET" && $method != "DELETE")) {
            $this->parameters["body"] = json_encode($body);
        }
    }
}
