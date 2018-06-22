<?php
declare(strict_types=1);

namespace LicenseChecker;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LicenseChecker\Builder\LicenseModelBuilder;
use LicenseChecker\Enum\License;
use LicenseChecker\Exception\ConnectionException;
use LicenseChecker\Exception\FileNotFoundException;
use LicenseChecker\Exception\WrongFileTypeException;
use LicenseChecker\Helper\Arguments;
use LicenseChecker\Helper\FileReader;
use LicenseChecker\Helper\JSON;
use LicenseChecker\Model\LicenseModel;

/**
 * @package LicenseChecker
 * @author  david.pauli
 * @since   20.06.2018
 */
class LicenseChecker
{
    private const FILTERED_LIBRARIES = ['php'];
    private const PACKAGE_PATH = 'https://packagist.org/packages/%s.json';
    private const LICENSE_MAPPING = [
        'Apache-2.0'        => License::APACHE2,
        'Apache2'           => License::APACHE2,
        'BSD-3-Clause'      => License::BSD3,
        'GPL-3.0'           => License::GPL3,
        'GPL-2.0-only'      => License::GPL2,
        'MIT'               => License::MIT,
        'LGPL-2.1'          => License::LGPL2x,
        'LGPL-2.1-or-later' => License::LGPL2x,
        'LGPL-3'            => License::LGPL3
    ];
    private const MESSAGE_RESPONSE_WRONG = 'The response to "%s" for lib "%s" version "%s" is not correct: "%s".';
    private const MESSAGE_STATUS_MESSAGE_WRONG = 'The request against "%s" response with "%d".';
    private const MESSAGE_UNKNOWN_LICENSE = 'The license "%s" is not known (yet).';
    private const SOURCE_PACKAGIST = 'packagist';

    /** @var FileReader */
    private $fileReader;

    /** @var Client */
    private $client;

    /** @var string[] */
    private $collectedProblems = [];

    /** @var LicenseModel[] */
    private $collectedLicenses = [];

    /**
     * @param string[] $args
     */
    public function __construct(array $args)
    {
        $this->fileReader = new FileReader((new Arguments($args))->getFileName());
        $this->client = new Client();
    }

    /**
     * @throws ConnectionException
     * @throws WrongFileTypeException
     * @throws FileNotFoundException
     */
    public function analyze(): void
    {
        $arrayOfComposer = JSON::decode($this->fileReader->fetchFileContent());
        $libraries = array_merge(
            array_diff_key($arrayOfComposer['require'] ?? [], array_flip(self::FILTERED_LIBRARIES)),
            array_diff_key($arrayOfComposer['require-dev'] ?? [], array_flip(self::FILTERED_LIBRARIES))
        );

        foreach ($libraries as $libName => $version) {
            /** @var Response $response */
            $response = $this->client->request('GET', sprintf(self::PACKAGE_PATH, $libName));
            if ($response->getStatusCode() === 200) {
                $responseArray = JSON::decode($response->getBody()->getContents());
                /** @var string[] $licenses */
                $latestVersion = reset($responseArray['package']['versions']);
                $licenses = $latestVersion['license'] ?? null;
                if ($licenses === null) {
                    throw new ConnectionException(sprintf(
                        self::MESSAGE_RESPONSE_WRONG,
                        sprintf(self::PACKAGE_PATH, $libName),
                        $libName,
                        $version,
                        $response->getBody()->getContents()
                    ));
                }
                foreach ($licenses as $license) {
                    $mappedName = self::LICENSE_MAPPING[$license] ?? null;
                    if ($mappedName === null) {
                        $this->collectedProblems[$libName] = sprintf(self::MESSAGE_UNKNOWN_LICENSE, $license);
                    } else {
                        $this->collectedLicenses[] = LicenseModelBuilder::buildFromArray([
                            'externalName' => $license,
                            'internalName' => self::LICENSE_MAPPING[$license]
                        ]);
                    }
                }
            } else {
                $this->collectedProblems[$libName] = sprintf(
                    self::MESSAGE_STATUS_MESSAGE_WRONG,
                    self::SOURCE_PACKAGIST,
                    $response->getStatusCode()
                );
            }
        }
    }
    /**
     * @return string[]
     */
    public function getCollectedProblems(): array
    {
        return $this->collectedProblems;
    }

    /**
     * @return LicenseModel[]
     */
    public function getCollectedLicenses(): array
    {
        return $this->collectedLicenses;
    }
}
