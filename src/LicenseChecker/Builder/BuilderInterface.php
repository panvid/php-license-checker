<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

/**
 * Interface BuilderInterface
 *
 * @package LicenseChecker\Builder
 */
interface BuilderInterface
{
    /**
     * @return mixed
     */
    public function build();
}
