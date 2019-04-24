<?php

namespace Balfour\LaravelSMS\Adapters;

use MasterStart\TotalSendSMS\TotalSendSMSClient;
use Propaganistas\LaravelPhone\PhoneNumber;

class TotalSendAdapter implements AdapterInterface
{
    /**
     * @var TotalSendSMSClient
     */
    protected $client;

    /**
     * @param TotalSendSMSClient $client
     */
    public function __construct(TotalSendSMSClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return TotalSendSMSClient
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param PhoneNumber $to
     * @param string $message
     * @param PhoneNumber|null $from
     * @return mixed
     */
    public function send(PhoneNumber $to, $message, PhoneNumber $from = null)
    {
        return $this->client->sendMessage(
            $to->formatE164(),
            $message,
            $from ? $from->formatE164() : null
        );
    }
}
