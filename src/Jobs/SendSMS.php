<?php

namespace Balfour\Proteus\SMS\Jobs;

use Balfour\LaravelSMS\ChannelManager;
use Balfour\LaravelSMS\HasMobileNumberInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use Propaganistas\LaravelPhone\PhoneNumber;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels, Queueable;

    /**
     * @var PhoneNumber
     */
    public $to;

    /**
     * @var string
     */
    public $message;

    /**
     * @var string|null
     */
    public $channel;

    /**
     * Create a new job instance.
     *
     * @param string|PhoneNumber|HasMobileNumberInterface $to
     * @param string $message
     * @param string|null $channel
     */
    public function __construct($to, $message, $channel = null)
    {
        if ($to instanceof HasMobileNumberInterface) {
            $this->to = $to->getMobileNumber();
        } elseif (is_string($to)) {
            $this->to = phone($to);
        } elseif ($to instanceof PhoneNumber) {
            $this->to = $to;
        } else {
            throw new InvalidArgumentException(
                'The $to argument must be an instance of HasMobileNumberInterface, PhoneNumber or string.'
            );
        }

        $this->message = $message;
        $this->channel = $channel;
    }

    /**
     * Execute the job.
     *
     * @param ChannelManager $manager
     */
    public function handle(ChannelManager $manager)
    {
        $manager->getChannel($this->channel)->send($this->to, $this->message);
    }

    /**
     * @param string|PhoneNumber|HasMobileNumberInterface $to
     * @param string $message
     * @param string|null $channel
     */
    public static function enqueue($to, $message, $channel = null)
    {
        static::dispatch($to, $message, $channel)->onQueue(config('sms.queue'));
    }
}
