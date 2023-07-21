<?php

namespace App\Controller;

use App\Message\SmsKafkaNotification;
use App\Message\SmsNotification;
use Enqueue\MessengerAdapter\EnvelopeItem\TransportConfiguration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{

    /**
     * @Route("/fila", name="fila", methods={"GET"})
    */
    public function fila(MessageBusInterface $bus)
    {
        // will cause the SmsNotificationHandler to be called
        $bus->dispatch(new SmsNotification('Look! I created a message!'));

        // ...
        return new Response(';) RabbitMQ - Mensagem Criada!!!');
    }

    /**
     * @Route("/kafka", name="kafka", methods={"GET"})
    */
    public function kafka(MessageBusInterface $bus)
    {
        // will cause the SmsNotificationHandler to be called
        $bus->dispatch(
            new SmsKafkaNotification('KAFKA! I created a message!')
        )->with(
            new TransportConfiguration(['topic'=>'pdde-emails'])
        );

        // ...
        return new Response(';) Mensagem Kafka Criada!!!');
    }

    /**
     * @Route("/php", name="php", methods={"GET"})
    */
    public function php()
    {
        $info = phpinfo();
        return new Response($info);
    }
}
