<?php
declare(strict_types=1);

use LicenseChecker\Helper\Output;
use LicenseChecker\LicenseChecker;

require __DIR__ . '/vendor/autoload.php';

define('ROOT_DIR', __DIR__);

$checker = new LicenseChecker($argv);
try {
    $checker->analyze();
} catch (Exception $exception) {
    Output::exception($exception);
}

foreach ($checker->getCollectedLicenses() as $license)
var_dump($checker->getCollectedLicenses());
print_r($checker->getCollectedProblems());