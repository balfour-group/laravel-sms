<?php

namespace Balfour\LaravelSMS;

use Balfour\LaravelSMS\Adapters\AdapterManager;
use UnexpectedValueException;

class ChannelManager
{
    /**
     * @var AdapterManager
     */
    protected $manager;

    /**
     * @var array
     */
    protected $channels = [];

    /**
     * @param AdapterManager $manager
     */
    public function __construct(AdapterManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return AdapterManager
     */
    public function getAdapterManager()
    {
        return $this->manager;
    }

    /**
     * @param string $name
     * @return Channel
     */
    public function getChannel($name)
    {
        if (!isset($this->channels[$name])) {
            $config = config('sms.channels.' . $name);

            if ($config === null) {
                throw new UnexpectedValueException(sprintf('The channel "%s" is not supported.', $name));
            }

            $adapter = $this->manager->resolve($config['driver']);

            $this->channels[$name] = new Channel(
                $name,
                $adapter,
                !empty($config['from']) ? phone($config['from']) : null
            );
        }

        return $this->channels[$name];
    }

    /**
     * @param string|null $name
     * @return Channel
     */
    public function channel($name = null)
    {
        if ($name === null) {
            $name = $this->getDefaultChannel();
        }

        return $this->getChannel($name);
    }

    /**
     * @return string
     */
    public function getDefaultChannel()
    {
        return config('sms.default');
    }
}
