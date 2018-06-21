<?php
declare(strict_types=1);

namespace LicenseChecker\Helper;

use Exception;

/**
 * @package LicenseChecker\Helper
 * @author  david.pauli
 * @since   20.06.2018
 */
class Output
{
    private const MESSAGE_EXCEPTION = '[ERR] %s: %s';

    /**
     * @param Exception $exception
     */
    public static function exception(Exception $exception): void
    {
        self::err(sprintf(self::MESSAGE_EXCEPTION, \get_class($exception), $exception->getMessage()));
    }

    /**
     * @param string $message
     */
    private static function err(string $message): void
    {
        echo print_r($message, true);
    }
}
