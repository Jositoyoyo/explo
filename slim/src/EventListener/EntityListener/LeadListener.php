<?php

namespace App\EventListener\EntityListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\User\Lead;

class LeadListener extends EntityListener {

    public function notify($entity): void {

        if ($entity instanceof Lead) {
            
            $mail = $this->container->get('mailerMultipleUsers');
            $config = $mail->getMailer();
            $config->getMessage()->setSubject('Nueva solicitud');
            $mail->query(['role' => 'ROLE_SUPER_ADMIN']);
            $mail->send('email/new-lead-information.html.twig', ['entity' => $entity]);
            
        }
    }

}
