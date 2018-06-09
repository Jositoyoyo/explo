<?php

namespace App\EventListener\EntityListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User;

class UserListener extends EntityListener {

    public function notify($entity): void {

        if ($entity instanceof User) {
            $mail = $this->container->get('mailerMultipleUsers');

            $config = $mail->getMailer();
            $config->getMessage()->setSubject('Se ha registador un nuevo usuario');

            $mail->query([
                'role' => 'ROLE_SUPER_ADMIN',
                'maxResults' => 30,
                'firstResult' => 0
            ]);

            $mail->send('email/user-registration.html.twig', ['user_register' => $entity]);
        }
    }

}
