<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

use LicenseChecker\Enum\Conditions;
use LicenseChecker\Model\PermissionModel;

/**
 * @package LicenseChecker\Builder
 * @author  david.pauli
 * @since   25.06.2018
 */
class PermissionModelBuilder implements BuilderInterface
{
    private const MODEL_NAME = PermissionModel::class;

    /**
     * @param  string[] $permission
     * @return PermissionModel
     */
    public static function buildFromArray(array $permission): PermissionModel
    {
        $modelName = self::MODEL_NAME;
        /** @var PermissionModel $model */
        $model = new $modelName();
        return $model
            ->setCondition($permission['condition'] ?? Conditions::UNDEFINED)
            ->setDescription($permission['description'] ?? '');
    }
}
