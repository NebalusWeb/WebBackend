<?php

namespace Nebalus\Webapi\Value\User\InvitationToken;

use IteratorAggregate;
use Traversable;

class InvitationTokens implements IteratorAggregate
{
    private array $invitationsTokens;

    private function __construct(InvitationToken ...$invitationsTokens)
    {
        $this->invitationsTokens = $invitationsTokens;
    }

    public static function fromArray(InvitationToken ...$invitationsTokens): self
    {
        return new self(...$invitationsTokens);
    }

    public function getIterator(): Traversable
    {
        yield from $this->invitationsTokens;
    }
}
