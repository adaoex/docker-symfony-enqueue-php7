<?php

namespace App\MessageHandler;

use App\Message\SmsKafkaNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SmsKafkaNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(SmsKafkaNotification $message)
    {
        // ... do some work - like sending an SMS message!
        # var_dump($message);
        echo '# KAFKA: '. $message->getContent();
    }
}
