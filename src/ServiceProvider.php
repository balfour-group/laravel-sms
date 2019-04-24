<?php

namespace Balfour\LaravelSMS;

use Balfour\LaravelSMS\Adapters\AdapterManager;
use Balfour\LaravelSMS\Adapters\TotalSendAdapter;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use MasterStart\TotalSendSMS\TotalSendSMSClient;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/config.php' => config_path('sms.php')], 'config');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(AdapterManager::class, function () {
            $manager = new AdapterManager();

            $this->registerAdapters($manager);

            return $manager;
        });

        $this->app->singleton(ChannelManager::class, function () {
            return new ChannelManager(app(AdapterManager::class));
        });
    }

    /**
     * @param AdapterManager $manager
     */
    protected function registerAdapters(AdapterManager $manager)
    {
        $this->registerTotalSendAdapter($manager);
    }

    /**
     * @param AdapterManager $manager
     */
    protected function registerTotalSendAdapter(AdapterManager $manager)
    {
        $manager->addAdapter('totalsend', function ($config) use ($manager) {
            $client = app(TotalSendSMSClient::class);
            /** @var TotalSendSMSClient $client */
            $client->setUsername($config['username']);
            $client->setPassword($config['password']);

            return new TotalSendAdapter($client);
        });
    }
}
