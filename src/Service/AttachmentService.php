<?php


namespace App\Service;


use App\Entity\Attachment;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AttachmentService implements AttachmentServiceInterface
{
    private $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
    }

    public function uploadAttachment(UploadedFile $attachment): Attachment
    {
        // On génère un nouveau nom de fichier
        $fichier = md5(uniqid()) . '.' . $attachment->guessExtension();

        // On copie le fichier dans le dossier uploads
        $attachment->move(
            $this->getTargetDirectory(),
            $fichier
        );

        // On crée l'image dans la base de données
        $attachment = new Attachment();
        $attachment->setName($fichier);

        return $attachment;
    }

    public function getTargetDirectory()
    {
        return $this->uploadDirectory;
    }
}