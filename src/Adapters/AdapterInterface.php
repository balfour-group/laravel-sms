<?php

namespace Balfour\LaravelSMS\Adapters;

use Propaganistas\LaravelPhone\PhoneNumber;

interface AdapterInterface
{
    /**
     * @param PhoneNumber $to
     * @param string $message
     * @param PhoneNumber|null $from
     * @return mixed
     */
    public function send(PhoneNumber $to, $message, PhoneNumber $from = null);
}
