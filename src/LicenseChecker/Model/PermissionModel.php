<?php
declare(strict_types=1);

namespace LicenseChecker\Model;

use LicenseChecker\Enum\Conditions;

/**
 * @package LicenseChecker\Model
 * @author  david.pauli
 * @since   25.06.2018
 */
class PermissionModel
{
    private $allowed = Conditions::UNDEFINED;
    private $description = '';

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowed(): bool
    {
        return $this->allowed === Conditions::YES;
    }

    /**
     * @return string
     */
    public function getAllowed(): string
    {
        return $this->allowed;
    }

    /**
     * @return PermissionModel
     */
    public function allow(): self
    {
        $this->allowed = Conditions::YES;
        return $this;
    }

    /**
     * @return PermissionModel
     */
    public function disallow(): self
    {
        $this->allowed = Conditions::NO;
        return $this;
    }
}
