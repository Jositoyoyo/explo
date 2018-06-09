<?php

namespace App\EventListener\EntityListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Item;

class ItemListener extends EntityListener {

    public function notify($entity): void {
        
        if ($entity instanceof Item) {
            $mail = $this->container->get('mailerMultipleUsers');

            $config = $mail->getMailer();
            $config->getMessage()->setSubject('Publicado un nuevo Item en el portal');

            $mail->query([
                'role' => 'ROLE_SUPER_ADMIN',
                'maxResults' => 30,
                'firstResult' => 0
            ]);

            $mail->send('email/item-new.html.twig', ['item' => $entity]);
        }
        
    }

}
