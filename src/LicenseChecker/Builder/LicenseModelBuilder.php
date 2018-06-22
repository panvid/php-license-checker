<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

use LicenseChecker\Exception\FileNotFoundException;
use LicenseChecker\Exception\WrongFileTypeException;
use LicenseChecker\Helper\FileReader;
use LicenseChecker\Helper\JSON;
use LicenseChecker\Model\LicenseModel;

/**
 * @author david.pauli
 * @since  21.06.2018
 */
class LicenseModelBuilder
{
    private const MODEL_NAME = LicenseModel::class;
    public const KEY_INTERNAL_NAME = 'internalName';
    public const KEY_EXTERNAL_NAME = 'externalName';
    private const PATH_TO_LICENSE_DEFINITION = ROOT_DIR . '/resources/licenses.json';

    /**
     * @param  string[] $names
     * @return LicenseModel
     * @throws WrongFileTypeException
     * @throws FileNotFoundException
     */
    public static function buildFromArray(array $names): LicenseModel
    {
        $internalName = $names[self::KEY_INTERNAL_NAME];

        $modelName = self::MODEL_NAME;
        /** @var LicenseModel $model */
        $model = new $modelName();
        $model->setInternalName($internalName)->setExternalName($names[self::KEY_EXTERNAL_NAME]);

        /** @var string[][][] $licenseDefinitions */
        $licenseDefinitions = JSON::decode((new FileReader(self::PATH_TO_LICENSE_DEFINITION))->fetchFileContent());
        $licenseDefinition = $licenseDefinitions[$internalName] ?? null;

        if ($licenseDefinition !== null) {
            $model->setCommercialUse($licenseDefinition['commercial']);
            $model->setModification($licenseDefinition['modification']);
            $model->setDistribution($licenseDefinition['distribution']);
            $model->setPrivateUse($licenseDefinition['privateUse']);
            $model->setLiability($licenseDefinition['liability']);
            $model->setWarranty($licenseDefinition['warranty']);
            $model->setConditions($licenseDefinition['conditions']);
        }

        return $model;
    }
}
