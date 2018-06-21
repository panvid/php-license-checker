<?php
declare(strict_types=1);

use LicenseChecker\Helper\Output;
use LicenseChecker\LicenseChecker;

require __DIR__ . '/vendor/autoload.php';

$checker = new LicenseChecker($argv);
try {
    $checker->analyze();
} catch (Exception $exception) {
    Output::exception($exception);
}

print_r($checker->getCollectedLicenses());
print_r($checker->getCollectedProblems());