<?php
declare(strict_types=1);

namespace LicenseChecker;

use LicenseChecker\Enum\Conditions;

/**
 * @package LicenseChecker
 * @author  david.pauli
 * @since   25.06.2018
 */
abstract class Constants
{
    public const FILTERED_LIBRARIES = ['php'];
    public const PERMISSION_MAPPING = [
        self::KEY_COMMERCIAL_USE => [
            Conditions::YES => 'The software and derivatives can be used for commercial purposes.',
            Conditions::NO => 'The software and derivatives can not be used for commercial purposes.'
        ],
        self::KEY_DISTRIBUTION => [
            Conditions::YES => 'The software can be distributed.',
            Conditions::NO => 'The software can not be distributed.'
        ],
        self::KEY_MODIFICATION => [
            Conditions::YES => 'The software can be modified.',
            Conditions::NO => 'The software can not be modified.'
        ],
        self::KEY_PATENT_USE => [
            Conditions::YES => 'The software can be used and modified as a patent.',
            Conditions::NO => 'The software can not be used and modified as a patent.'
        ],
        self::KEY_PRIVATE_USE => [
            Conditions::YES => 'The software can be used and modified in private.',
            Conditions::NO => 'The software can not be used and modified in private.'
        ]
    ];
    public const PACKAGE_PATH = 'https://packagist.org/packages/%s.json';
    public const KEY_COMMERCIAL_USE = 'commercialUse';
    public const KEY_DISTRIBUTION = 'distribution';
    public const KEY_MODIFICATION = 'modification';
    public const KEY_PATENT_USE = 'patentUse';
    public const KEY_PRIVATE_USE = 'privateUse';
}
