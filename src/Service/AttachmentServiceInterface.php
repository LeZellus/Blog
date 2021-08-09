<?php


namespace App\Service;


use App\Entity\Attachment;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface AttachmentServiceInterface
{
    public function uploadAttachment(UploadedFile $attachment): Attachment;
}