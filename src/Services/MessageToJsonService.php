<?php

namespace App\Services;

use App\Entity\ContactMessage;
use Psr\Log\LoggerInterface;


class MessageToJsonService
{
    protected LoggerInterface $logger;
    protected $jsonPath;

    public function __construct($jsonPath, LoggerInterface $logger){
       $this->jsonPath = $jsonPath;
       $this->logger = $logger;
    }

    /**
     * Service to save message in Json
     * 
     *  We could make it even more generic and transmit the object and the output name to be able to use it for other entities
     */
    public function save(ContactMessage $contactMessage): void
    {
        $filename = $this->jsonPath . 'message-' . $contactMessage->getCreatedAt()->format('Y-m-d H:i:s') . '.json';

        if (!file_exists($filename)) {
            try {
                mkdir($this->jsonPath, 0755, true);
            } catch (\Exception $e) {
                $this->logger->error('Error creating new dir ...', [
                    'filename' => $filename,
                    'error' => $e,
                ]);
            }
        }
        try {
            file_put_contents($filename, $contactMessage->jsonSerialize());
        } catch (\Exception $e) {
            $this->logger->error('Error putting content ...', ['error' => $e]);
        }
    }
}