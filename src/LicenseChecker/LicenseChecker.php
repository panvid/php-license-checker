<?php
declare(strict_types=1);

namespace LicenseChecker;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LicenseChecker\Builder\LicenseModelBuilder;
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
    private const MESSAGE_RESPONSE_WRONG = 'The response to "%s" for lib "%s" version "%s" is not correct: "%s".';
    private const MESSAGE_STATUS_MESSAGE_WRONG = 'The request against "%s" response with "%d".';
    private const MESSAGE_UNKNOWN_LICENSE = 'The license "%s" is not known (yet).';

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
            array_diff_key($arrayOfComposer['require'] ?? [], array_flip(Constants::FILTERED_LIBRARIES)),
            array_diff_key($arrayOfComposer['require-dev'] ?? [], array_flip(Constants::FILTERED_LIBRARIES))
        );

        foreach ($libraries as $libName => $version) {
            $requestPath = sprintf(Constants::PACKAGE_PATH, $libName);
            /** @var Response $response */
            $response = $this->client->request('GET', $requestPath);
            if ($response->getStatusCode() === 200) {
                $responseArray = JSON::decode($response->getBody()->getContents());
                /** @var string[] $licenses */
                $latestVersion = reset($responseArray['package']['versions']);
                $licenses = $latestVersion['license'] ?? null;
                if ($licenses === null) {
                    throw new ConnectionException(sprintf(
                        self::MESSAGE_RESPONSE_WRONG,
                        $requestPath,
                        $libName,
                        $version,
                        $response->getBody()->getContents()
                    ));
                }
                foreach ($licenses as $license) {
                    $mappedName = Constants::LICENSE_MAPPING[$license] ?? null;
                    if ($mappedName === null) {
                        $this->collectedProblems[$libName] = sprintf(self::MESSAGE_UNKNOWN_LICENSE, $license);
                    } else {
                        $this->collectedLicenses[$libName] = LicenseModelBuilder::buildFromArray([
                            Constants::KEY_EXTERNAL_NAME => $license,
                            Constants::KEY_INTERNAL_NAME => Constants::LICENSE_MAPPING[$license]
                        ]);
                    }
                }
            } else {
                $this->collectedProblems[$libName] = sprintf(
                    self::MESSAGE_STATUS_MESSAGE_WRONG,
                    $requestPath,
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
