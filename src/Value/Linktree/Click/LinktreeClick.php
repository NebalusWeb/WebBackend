<?php

namespace Nebalus\Webapi\Value\Linktree\Click;

use DateTimeImmutable;
use Nebalus\Webapi\Value\Linktree\LinktreeId;

class LinktreeClick
{
    private function __construct(
        private readonly LinktreeClickId $linktreeClickId,
        private readonly LinktreeId $linktreeId,
        private readonly DateTimeImmutable $clickedAt
    ) {
    }

    public static function from(LinktreeClickId $linktreeClickId, LinktreeId $linktreeId, DateTimeImmutable $clickedAt): self
    {
        return new self($linktreeClickId, $linktreeId, $clickedAt);
    }

    public function getLinktreeClickId(): LinktreeClickId
    {
        return $this->linktreeClickId;
    }

    public function getLinktreeId(): LinktreeId
    {
        return $this->linktreeId;
    }

    public function getClickedAt(): DateTimeImmutable
    {
        return $this->clickedAt;
    }
}