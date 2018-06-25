<?php
declare(strict_types=1);

namespace LicenseChecker;

use LicenseChecker\Enum\Conditions;
use LicenseChecker\Enum\License;

/**
 * @package LicenseChecker
 * @author  david.pauli
 * @since   25.06.2018
 */
abstract class Constants
{
    public const FILTERED_LIBRARIES = ['php'];
    public const KEY_INTERNAL_NAME = 'internalName';
    public const KEY_EXTERNAL_NAME = 'externalName';
    public const LICENSE_MAPPING = [
        'Apache-2.0'        => License::APACHE2,
        'Apache2'           => License::APACHE2,
        'GPL-2.0-only'      => License::GPL2,
        'BSD-3-Clause'      => License::BSD3,
        'GPL-3.0'           => License::GPL3,
        'MIT'               => License::MIT,
        'LGPL-2.1'          => License::LGPL2x,
        'LGPL-2.1-or-later' => License::LGPL2x,
        'LGPL-3'            => License::LGPL3
    ];
    public const MAP_COMMERCIAL_USE_DESCRIPTION = [
        Conditions::YES => 'The software and derivatives can be used for commercial purposes.',
        Conditions::NO => 'The software and derivatives can not be used for commercial purposes.'
    ];
    public const MAP_MODIFICATION_DESCRIPTION = [
        Conditions::YES => 'The software can be modified.',
        Conditions::NO => 'The software can not be modified.'
    ];
    public const MAP_DISTRIBUTION_DESCRIPTION = [
        Conditions::YES => 'The software can be distributed.',
        Conditions::NO => 'The software can not be distributed.'
    ];
    public const MAP_PATENT_USE_DESCRIPTION = [
        Conditions::YES => 'The software can be used and modified as a patent.',
        Conditions::NO => 'The software can not be used and modified as a patent.'
    ];
    public const MAP_PRIVATE_USE_DESCRIPTION = [
        Conditions::YES => 'The software can be used and modified in private.',
        Conditions::NO => 'The software can not be used and modified in private.'
    ];
    public const MAP_LIABILITY_DESCRIPTION = [
        Conditions::YES => 'The software includes full liability.',
        Conditions::NO => 'The license includes a limitation of liability.'
    ];
    public const MAP_WARRANTY_DESCRIPTION = [
        Conditions::YES => 'The software give warranty.',
        Conditions::NO => 'The software does not give any warranty.'
    ];
    public const PACKAGE_PATH = 'https://packagist.org/packages/%s.json';
}
