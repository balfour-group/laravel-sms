<?php

namespace Balfour\LaravelSMS;

use Propaganistas\LaravelPhone\PhoneNumber;

interface HasMobileNumberInterface
{
    /**
     * @return PhoneNumber
     */
    public function getMobileNumber();
}
