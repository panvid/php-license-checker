<?php
declare(strict_types=1);

namespace LicenseChecker\Builder;

use LicenseChecker\Constants;
use LicenseChecker\Model\PermissionModel;

/**
 * @package  LicenseChecker\Builder
 * @author   david.pauli
 * @since    25.06.2018
 * @property PermissionModel $objectToBuild
 */
class PermissionModelBuilder extends AbstractBuilder
{
    protected const MODEL_NAME = PermissionModel::class;

    private $permissionName = '';

    /**
     * @param  string $name
     * @return PermissionModelBuilder
     */
    public function name(string $name): self
    {
        $this->permissionName = $name;
        return $this;
    }

    /**
     * @param  bool $allowed
     * @return PermissionModelBuilder
     */
    public function allowed(bool $allowed): self
    {
        if ($allowed) {
            $this->objectToBuild->allow();
        } else {
            $this->objectToBuild->disallow();
        }
        return $this;
    }

    /**
     * @return PermissionModel
     */
    public function build(): PermissionModel
    {
        return $this->objectToBuild->setDescription(
            Constants::PERMISSION_MAPPING[$this->permissionName][$this->objectToBuild->getAllowed()] ?? ''
        );
    }
}
