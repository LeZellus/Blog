<?php


namespace App\Service;


use App\Entity\Attachment;

class AttachmentService
{
    public function uploadAttachment($attachment)
    {
        // On génère un nouveau nom de fichier
        $fichier = md5(uniqid()).'.'.$attachment->guessExtension();

        // On copie le fichier dans le dossier uploads
        $attachment->move(
            $this->getParameter('upload_directory'),
            $fichier
        );

        // On crée l'image dans la base de données
        $attachment = new Attachment();
        $attachment->setName($fichier);

        return $attachment;
    }
}