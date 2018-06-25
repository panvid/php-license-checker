<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

use LicenseChecker\Constants;
use LicenseChecker\Exception\FileNotFoundException;
use LicenseChecker\Exception\WrongFileTypeException;
use LicenseChecker\Helper\FileReader;
use LicenseChecker\Helper\JSON;
use LicenseChecker\Model\LicenseModel;

/**
 * @author david.pauli
 * @since  21.06.2018
 */
class LicenseModelBuilder implements BuilderInterface
{
    private const MODEL_NAME = LicenseModel::class;
    private const PATH_TO_LICENSE_DEFINITION = ROOT_DIR . '/resources/licenses.json';

    /**
     * @param  string[] $names
     * @return LicenseModel
     * @throws WrongFileTypeException
     * @throws FileNotFoundException
     */
    public static function buildFromArray(array $names): LicenseModel
    {
        $internalName = $names[Constants::KEY_INTERNAL_NAME];

        $modelName = self::MODEL_NAME;
        /** @var LicenseModel $model */
        $model = new $modelName();
        $model->setInternalName($internalName)->setExternalName($names[Constants::KEY_EXTERNAL_NAME]);

        /** @var string[][][] $licenseDefinitions */
        $licenseDefinitions = JSON::decode((new FileReader(self::PATH_TO_LICENSE_DEFINITION))->fetchFileContent());
        $licenseDefinition = $licenseDefinitions[$internalName] ?? [];

        return $model
            ->setCommercialUse($licenseDefinition['commercial'] ?? [])
            ->setModification($licenseDefinition['modification'] ?? [])
            ->setDistribution($licenseDefinition['distribution'] ?? [])
            ->setPrivateUse($licenseDefinition['privateUse'] ?? [])
            ->setLiability($licenseDefinition['liability'] ?? [])
            ->setWarranty($licenseDefinition['warranty'] ?? [])
            ->setConditions($licenseDefinition['conditions'] ?? []);
    }
}
