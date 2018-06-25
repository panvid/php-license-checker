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
     * @param  string[] $parameter
     * @return mixed
     */
    public static function buildFromArray(array $parameter);
}
