<?php
declare(strict_types=1);

namespace LicenseChecker;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use LicenseChecker\Builder\LicenseModelBuilder;
use LicenseChecker\Exception\ClassNotFoundException;
use LicenseChecker\Exception\ConnectionException;
use LicenseChecker\Exception\FileNotFoundException;
use LicenseChecker\Exception\UnknownLicenceException;
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

    /** @var FileReader */
    private $fileReader;

    /** @var Client */
    private $client;

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
     * @throws UnknownLicenceException
     * @throws ClassNotFoundException
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
                foreach ($licenses as $externalName) {
                    $this->collectedLicenses[$libName] = (new LicenseModelBuilder)
                        ->externalName($externalName)
                        ->build();
                }
            } else {
                throw new ConnectionException(sprintf(
                    self::MESSAGE_STATUS_MESSAGE_WRONG,
                    $requestPath,
                    $response->getStatusCode()
                ));
            }
        }
    }

    /**
     * @return LicenseModel[]
     */
    public function getCollectedLicenses(): array
    {
        return $this->collectedLicenses;
    }
}
