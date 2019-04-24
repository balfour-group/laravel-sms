<?php

namespace Balfour\LaravelSMS\Adapters;

use Closure;
use UnexpectedValueException;

class AdapterManager
{
    /**
     * @var array
     */
    protected $adapters = [];

    /**
     * @param string $adapter
     * @param Closure $resolver
     */
    public function addAdapter($adapter, Closure $resolver)
    {
        $this->adapters[$adapter] = $resolver;
    }

    /**
     * @param string $adapter
     * @param Closure $resolver
     */
    public function extend($adapter, Closure $resolver)
    {
        $this->addAdapter($adapter, $resolver);
    }

    /**
     * @return array
     */
    public function getResolvers()
    {
        return $this->adapters;
    }

    /**
     * @param string $adapter
     * @param array $config
     * @return AdapterInterface
     */
    public function getAdapter($adapter, array $config = [])
    {
        if (!isset($this->adapters[$adapter])) {
            throw new UnexpectedValueException(sprintf('The adapter "%s" is not registered.', $adapter));
        }

        return call_user_func($this->adapters[$adapter], $config);
    }

    /**
     * @param string $adapter
     * @param array $config
     * @return AdapterInterface
     */
    public function resolve($adapter, array $config = [])
    {
        return $this->getAdapter($adapter, $config);
    }
}
