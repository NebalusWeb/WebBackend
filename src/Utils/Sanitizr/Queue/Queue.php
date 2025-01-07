<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Queue;

class Queue
{
    private null|QueueNode $firstNode;
    private null|QueueNode $lastNode;
    private int $length;

    public function __construct()
    {
        $this->firstNode = null;
        $this->lastNode = null;
        $this->length = 0;
    }

    public function enqueue($value): void
    {
        $newNode = new QueueNode($value);
        $this->length++;

        if ($this->length == 0) {
            $this->firstNode = $newNode;
            $this->lastNode = $newNode;
            return;
        }

        $this->lastNode->setNextNode($newNode);
        $this->lastNode = $newNode;
    }

    public function dequeue(): mixed
    {
        if ($this->length == 0) {
            return null;
        }

        $temp = $this->firstNode;

        if ($this->length == 1) {
            $this->firstNode = null;
            $this->lastNode = null;
            $this->length--;
            return $temp->getValue();
        }

        $this->firstNode = $this->firstNode->getNextNode();
        $this->length--;
        return $temp->getValue();
    }
}
