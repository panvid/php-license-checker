<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

use LicenseChecker\Constants;
use LicenseChecker\Exception\ClassNotFoundException;
use LicenseChecker\Exception\FileNotFoundException;
use LicenseChecker\Exception\UnknownLicenceException;
use LicenseChecker\Exception\WrongFileTypeException;
use LicenseChecker\Helper\FileReader;
use LicenseChecker\Helper\JSON;
use LicenseChecker\Model\LicenseModel;

/**
 * @author   david.pauli
 * @since    21.06.2018
 * @property LicenseModel $objectToBuild
 */
class LicenseModelBuilder extends AbstractBuilder
{
    protected const MODEL_NAME = LicenseModel::class;
    private const PATH_TO_LICENSE_DEFINITION = ROOT_DIR . '/resources/licenses.json';
    private const MESSAGE_UNKNOWN_LICENSE = 'Unknown license %s.';

    /**
     * @param  string $name
     * @return LicenseModelBuilder
     */
    public function externalName(string $name): self
    {
        $this->objectToBuild->setExternalName($name);
        return $this;
    }

    /**
     * @return LicenseModel
     * @throws ClassNotFoundException
     * @throws UnknownLicenceException
     * @throws WrongFileTypeException
     * @throws FileNotFoundException
     */
    public function build(): LicenseModel
    {
        $licenseDefinitions = JSON::decode((new FileReader(self::PATH_TO_LICENSE_DEFINITION))->fetchFileContent());

        $internalName = $this->findInternalName($licenseDefinitions, $this->objectToBuild->getExternalName());

        if ($internalName === '') {
            throw new UnknownLicenceException(sprintf(
                self::MESSAGE_UNKNOWN_LICENSE,
                $this->objectToBuild->getExternalName()
            ));
        }

        $licenseDefinition = $licenseDefinitions[$internalName] ?? [];

        return $this->objectToBuild
            ->setInternalName($internalName)
            ->setLicenseDescription($licenseDefinition['description'] ?? '')
            ->setCommercialUse($licenseDefinition[Constants::KEY_COMMERCIAL_USE] ?? null)
            ->setModification($licenseDefinition[Constants::KEY_MODIFICATION] ?? null)
            ->setDistribution($licenseDefinition[Constants::KEY_DISTRIBUTION] ?? null)
            ->setPatentUse($licenseDefinition[Constants::KEY_PATENT_USE] ?? null)
            ->setPrivateUse($licenseDefinition[Constants::KEY_PRIVATE_USE] ?? null);
    }

    /**
     * Searchs an internal license name for an external definition.
     *
     * @param  array  $licences
     * @param  string $externalName
     * @return string
     */
    private function findInternalName(array $licences, string $externalName): string
    {
        $internalName = '';
        foreach ($licences as $licenceName => $licence) {
            if (\in_array($externalName, $licence['externalNames'] ?? [], true)) {
                $internalName = $licenceName;
            }
        }
        return $internalName;
    }
}
