<?php
declare(strict_types=1);

namespace LicenseChecker\Helper;

use LicenseChecker\Exception\WrongFileTypeException;

/**
 * @package  licenseChecker\Helper
 * @author   david.pauli
 * @since    20.06.2018
 */
class JSON
{
    private const MESSAGE_WRONG_FILE_TYPE = 'File content is no JSON: "%s".';

    /**
     * @param  string $json
     * @return array
     * @throws WrongFileTypeException
     */
    public static function decode(string $json): array
    {
        $jsonOutput = json_decode($json, true);
        if (false === is_array($jsonOutput)) {
            throw new WrongFileTypeException(sprintf(self::MESSAGE_WRONG_FILE_TYPE, $json));
        }
        return $jsonOutput;
    }
}
