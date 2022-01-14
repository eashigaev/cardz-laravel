<?php

namespace Codderz\YokoLite\Domain;

trait OptimisticLockingTrait
{
    private ?int $metaVersion = 0;

    public function withMetaVersion($value)
    {
        $this->metaVersion = $value;
        return $this;
    }

    public function nextMetaVersion()
    {
        return $this->metaVersion + 1;
    }

    public function getMetaVersion()
    {
        return $this->metaVersion;
    }
}
