<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Queue;

class QueueNode
{
    private mixed $value;
    private null|QueueNode $nextNode;

    public function __construct(mixed $value)
    {
        $this->value = $value;
        $this->nextNode = null;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setNextNode(null|QueueNode $nextNode): void
    {
        $this->nextNode = $nextNode;
    }

    public function getNextNode(): null | QueueNode
    {
        return $this->nextNode;
    }
}
