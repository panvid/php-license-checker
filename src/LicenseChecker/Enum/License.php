<?php
declare(strict_types=1);

namespace LicenseChecker\Enum;

/**
 * @author  david.pauli
 * @since   20.06.2018
 */
abstract class License
{
    public const MIT = 'MIT';
    public const BSD3 = 'BSD 3';
    public const APACHE2 = 'Apache 2';
    public const LGPL2x = 'LGPL 2.x';
    public const LGPL3 = 'LGPL 3';
    public const GPL3 = 'GPL3';
    public const GPL2 = 'GPL2';
}
