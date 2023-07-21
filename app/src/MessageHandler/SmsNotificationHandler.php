<?php

namespace App\MessageHandler;

use App\Message\SmsNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SmsNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(SmsNotification $message)
    {
        // ... do some work - like sending an SMS message!
        # var_dump($message);
        echo '# RETORNO: '. $message->getContent();
    }
}
