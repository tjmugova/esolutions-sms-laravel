<?php


namespace Tjmugova\EsolutionsSms;


use Illuminate\Http\Client\Factory;
use Tjmugova\EsolutionsSms\Exceptions\HttpException;
use Tjmugova\EsolutionsSms\Messages\EsolutionsSmsMessage;

class EsolutionsSms
{
    /**
     * The HTTP client instance.
     *
     * @var Factory
     */
    protected $http;
    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $config;

    public function __construct(Factory $httpClient, $config)
    {
        $this->http = $httpClient;
        $this->config = $config;
    }

    /**
     * @param array $payload
     * @return mixed
     * @throws HttpException
     */
    public function sendMessage(array $payload)
    {
        try {
            $response = $this->http->withBasicAuth(
                $this->config['username'],
                $this->config['password']
            )->post($this->config['api_url'].'/api/single', [
                'originator' => $payload['from'] ?? $this->config['sms_from'],
                'destination' => $payload['to'],
                'messageText' => $payload['text'],
                'messageReference' => $payload['message_reference'] ?? uniqid('SMS_'),
                'messageDate' => date('YmdHis'),
            ]);
            return $response->json();

        } catch (\Throwable $e) {
            throw new HttpException($e->getMessage(), 4003);
        }
    }

    /**
     * Check status of a single message
     * 
     * @param string $messageReference
     * @return mixed
     * @throws HttpException
     */
    public function checkSingleMessageStatus(string $messageReference)
    {
        try {
            $response = $this->http->withBasicAuth(
                $this->config['username'],
                $this->config['password']
            )->post($this->config['api_url'].'/api/status/single', [
                'messageReference' => $messageReference,
            ]);
            return $response->json();

        } catch (\Throwable $e) {
            throw new HttpException($e->getMessage(), 4003);
        }
    }

    /**
     * Send bulk messages to multiple recipients
     * 
     * @param array $payload
     * @return mixed
     * @throws HttpException
     */
    public function sendBulkMessage(array $payload)
    {
        try {
            $messages = [];
            
            // Handle array of destinations with same message
            if (isset($payload['to']) && is_array($payload['to'])) {
                foreach ($payload['to'] as $destination) {
                    $messages[] = [
                        'originator' => $payload['from'] ?? $this->config['sms_from'],
                        'destination' => $destination,
                        'messageText' => $payload['text'],
                        'messageReference' => $payload['message_reference'] ?? uniqid('SMS_'),
                    ];
                }
            }
            
            // Handle array of individual messages
            if (isset($payload['messages']) && is_array($payload['messages'])) {
                foreach ($payload['messages'] as $message) {
                    $messages[] = [
                        'originator' => $message['originator'] ?? $payload['from'] ?? $this->config['sms_from'],
                        'destination' => $message['destination'],
                        'messageText' => $message['messageText'],
                        'messageReference' => $message['messageReference'] ?? uniqid('SMS_'),
                    ];
                }
            }
            
            $response = $this->http->withBasicAuth(
                $this->config['username'],
                $this->config['password']
            )->post($this->config['api_url'].'/api/bulk', [
                'batchNumber' => $payload['batch_number'] ?? uniqid('BATCH_'),
                'messages' => $messages,
            ]);
            return $response->json();

        } catch (\Throwable $e) {
            throw new HttpException($e->getMessage(), 4003);
        }
    }

    /**
     * Check status of bulk messages
     * 
     * @param string $messageReference
     * @return mixed
     * @throws HttpException
     */
    public function checkBulkMessageStatus(string $messageReference)
    {
        try {
            $response = $this->http->withBasicAuth(
                $this->config['username'],
                $this->config['password']
            )->post($this->config['api_url'].'/api/status/bulk', [
                'messageReference' => $messageReference,
            ]);
            return $response->json();

        } catch (\Throwable $e) {
            throw new HttpException($e->getMessage(), 4003);
        }
    }

    /**
     * Get account balance
     * 
     * @return mixed
     * @throws HttpException
     */
    public function getBalance()
    {
        try {
            $response = $this->http->withBasicAuth(
                $this->config['username'],
                $this->config['password']
            )->post($this->config['api_url'].'/api/balance', []);
            return $response->json();

        } catch (\Throwable $e) {
            throw new HttpException($e->getMessage(), 4003);
        }
    }
}