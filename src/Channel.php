<?php

namespace Balfour\LaravelSMS;

use Balfour\LaravelSMS\Adapters\AdapterInterface;
use Propaganistas\LaravelPhone\PhoneNumber;

class Channel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var PhoneNumber|null
     */
    protected $from;

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param string $name
     * @param AdapterInterface $adapter
     * @param PhoneNumber|null $from
     */
    public function __construct($name, AdapterInterface $adapter, PhoneNumber $from = null)
    {
        $this->name = $name;
        $this->adapter = $adapter;
        $this->from = $from;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param PhoneNumber $to
     * @param string $message
     * @return mixed
     */
    public function send(PhoneNumber $to, $message)
    {
        return $this->adapter->send($to, $message, $this->from);
    }
}
