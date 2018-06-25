<?php
declare(strict_types=1);

namespace LicenseChecker\Helper;

use LicenseChecker\Exception\FileNotFoundException;

/**
 * @package LicenseChecker\Helper
 * @author  david.pauli
 * @since   20.06.2018
 */
class FileReader
{
    private const MESSAGE_NOT_FOUND = 'File "%s" is not found.';

    /** @var string */
    private $fileName;

    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return string
     * @throws FileNotFoundException
     */
    public function fetchFileContent(): string
    {
        if (false === file_exists($this->fileName)) {
            throw new FileNotFoundException(sprintf(self::MESSAGE_NOT_FOUND, $this->fileName));
        }
        $content = @file_get_contents($this->fileName);
        if ($content === false) {
            throw new FileNotFoundException(sprintf(self::MESSAGE_NOT_FOUND, $this->fileName));
        }
        return $content;
    }
}
