<?php
declare(strict_types=1);

namespace LicenseChecker\Model;

use LicenseChecker\Builder\PermissionModelBuilder;
use LicenseChecker\Constants;
use LicenseChecker\Enum\Conditions;

/**
 * @author david.pauli
 * @since  21.06.2018
 */
class LicenseModel
{
    /** @var string The name called in library. */
    private $externalName;

    /** @var string The internal name. */
    private $internalName;

    /** @var string The description. */
    private $licenseDescription;

    /** @var PermissionModel */
    private $commercialUse;

    /** @var PermissionModel */
    private $modification;

    /** @var PermissionModel */
    private $distribution;

    /** @var PermissionModel */
    private $patentUse;

    /** @var PermissionModel */
    private $privateUse;

    /** @var PermissionModel */
    private $liability;

    /** @var PermissionModel */
    private $warranty;

    /** @var string[] */
    private $conditions = [];

    /**
     * @return string|null
     */
    public function getExternalName(): ?string
    {
        return $this->externalName;
    }

    /**
     * @param  string $externalName
     * @return self
     */
    public function setExternalName(string $externalName): self
    {
        $this->externalName = $externalName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getInternalName(): string
    {
        return $this->internalName;
    }

    /**
     * @param  string $internalName
     * @return self
     */
    public function setInternalName(string $internalName): self
    {
        $this->internalName = $internalName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLicenseDescription(): string
    {
        return $this->licenseDescription;
    }

    /**
     * @param  string $licenseDescription
     * @return self
     */
    public function setLicenseDescription(string $licenseDescription): self
    {
        $this->licenseDescription = $licenseDescription;
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getCommercialUse(): ?PermissionModel
    {
        return $this->commercialUse;
    }

    /**
     * @param  string[] $commercialUse
     * @return self
     */
    public function setCommercialUse(array $commercialUse): self
    {
        $this->commercialUse = PermissionModelBuilder::buildFromArray([
            'condition'   => $commercialUse['condition'] ?? Conditions::UNDEFINED,
            'description' => $commercialUse['description']
                ?? Constants::MAP_COMMERCIAL_USE_DESCRIPTION[$commercialUse['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getModification(): ?PermissionModel
    {
        return $this->modification;
    }

    /**
     * @param  string[] $modification
     * @return self
     */
    public function setModification(array $modification): self
    {
        $this->modification = PermissionModelBuilder::buildFromArray([
            'condition'   => $modification['condition'] ?? Conditions::UNDEFINED,
            'description' => $modification['description']
                ?? Constants::MAP_MODIFICATION_DESCRIPTION[$modification['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getDistribution(): ?PermissionModel
    {
        return $this->distribution;
    }

    /**
     * @param  string[] $distribution
     * @return self
     */
    public function setDistribution(array $distribution): self
    {
        $this->distribution = PermissionModelBuilder::buildFromArray([
            'condition'   => $distribution['condition'] ?? Conditions::UNDEFINED,
            'description' => $distribution['description']
                ?? Constants::MAP_DISTRIBUTION_DESCRIPTION[$distribution['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getPatentUse(): ?PermissionModel
    {
        return $this->patentUse;
    }

    /**
     * @param  string[] $patentUse
     * @return self
     */
    public function setPatentUse(array $patentUse): self
    {
        $this->patentUse = PermissionModelBuilder::buildFromArray([
            'condition'   => $patentUse['condition'] ?? Conditions::UNDEFINED,
            'description' => $patentUse['description']
                ?? Constants::MAP_PATENT_USE_DESCRIPTION[$patentUse['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getPrivateUse(): ?PermissionModel
    {
        return $this->privateUse;
    }

    /**
     * @param  string[] $privateUse
     * @return self
     */
    public function setPrivateUse(array $privateUse): self
    {
        $this->privateUse = PermissionModelBuilder::buildFromArray([
            'condition'   => $privateUse['condition'] ?? Conditions::UNDEFINED,
            'description' => $privateUse['description']
                ?? Constants::MAP_PRIVATE_USE_DESCRIPTION[$privateUse['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getLiability(): ?PermissionModel
    {
        return $this->liability;
    }

    /**
     * @param  string[] $liability
     * @return self
     */
    public function setLiability(array $liability): self
    {
        $this->liability = PermissionModelBuilder::buildFromArray([
            'condition'   => $liability['condition'] ?? Conditions::UNDEFINED,
            'description' => $liability['description']
                ?? Constants::MAP_LIABILITY_DESCRIPTION[$liability['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return PermissionModel|null
     */
    public function getWarranty(): ?PermissionModel
    {
        return $this->warranty;
    }

    /**
     * @param  string[] $warranty
     * @return self
     */
    public function setWarranty(array $warranty): self
    {
        $this->warranty = PermissionModelBuilder::buildFromArray([
            'condition'   => $warranty['condition'] ?? Conditions::UNDEFINED,
            'description' => $warranty['description']
                ?? Constants::MAP_WARRANTY_DESCRIPTION[$warranty['condition'] ?? '']
                ?? ''
        ]);
        return $this;
    }

    /**
     * @return string[]
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param  string[] $conditions
     * @return self
     */
    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->internalName . ' as ' . $this->externalName;
    }
}
