<?php

namespace Codderz\YokoLite\Domain;

/**
 * Migration: $table->integer('meta_version')->nullable();
 * Where: 'meta_version' => $aggregate->getMetaVersion()
 * Update: 'meta_version' => $aggregate->nextMetaVersion()
 */
trait OptimisticLockingTrait
{
    private ?int $metaVersion = null;

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
