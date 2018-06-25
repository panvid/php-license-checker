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
    private $condition = Conditions::UNDEFINED;
    private $description = '';

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param  string $condition
     * @return self
     */
    public function setCondition(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

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
        return $this->condition === Conditions::YES;
    }
}
