<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

use LicenseChecker\Exception\ClassNotFoundException;

/**
 * @package LicenseChecker\Builder
 * @author  david.pauli
 * @since   29.06.2018
 */
abstract class AbstractBuilder implements BuilderInterface
{
    protected const MODEL_NAME = '';
    private const MESSAGE_CLASS_NOT_FOUND = 'Cannot build class %s: It is not found.';

    protected $objectToBuild;

    /**
     * @throws ClassNotFoundException
     */
    public function __construct()
    {
        if (false === class_exists(self::MODEL_NAME)) {
            throw new ClassNotFoundException(sprintf(self::MESSAGE_CLASS_NOT_FOUND, self::MODEL_NAME));
        }

        $modelName = self::MODEL_NAME;
        $this->objectToBuild = new $modelName();
    }
}
