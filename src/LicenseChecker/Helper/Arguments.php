<?php
declare(strict_types=1);

namespace LicenseChecker\Helper;

/**
 * @author david.pauli
 * @since  20.06.2018
 */
class Arguments
{
    /** @var string */
    private $fileName;

    /**
     * @param string[] $arguments
     */
    public function __construct(array $arguments)
    {
        array_shift($arguments);
        if (count($arguments) === 1) {
            $this->fileName = reset($arguments);
        }
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return (string) $this->fileName;
    }
}
