<?php
declare(strict_types=1);

namespace LicenseChecker\Model;

use LicenseChecker\Builder\PermissionModelBuilder;
use LicenseChecker\Constants;
use LicenseChecker\Exception\ClassNotFoundException;

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
     * @param  bool|null $allowed
     * @return self
     * @throws ClassNotFoundException
     */
    public function setCommercialUse(?bool $allowed): self
    {
        $builder = (new PermissionModelBuilder())->name(Constants::KEY_COMMERCIAL_USE);
        if ($allowed !== null) {
            $builder->allowed($allowed);
        }
        $this->commercialUse = $builder->build();
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
     * @param  bool|null $allowed
     * @return self
     * @throws ClassNotFoundException
     */
    public function setModification(?bool $allowed): self
    {
        $builder = (new PermissionModelBuilder())->name(Constants::KEY_MODIFICATION);
        if ($allowed !== null) {
            $builder->allowed($allowed);
        }
        $this->modification = $builder->build();
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
     * @param  bool|null $allowed
     * @return self
     * @throws ClassNotFoundException
     */
    public function setDistribution(?bool $allowed): self
    {
        $builder = (new PermissionModelBuilder())->name(Constants::KEY_DISTRIBUTION);
        if ($allowed !== null) {
            $builder->allowed($allowed);
        }
        $this->distribution = $builder->build();
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
     * @param  bool|null $allowed
     * @return self
     * @throws ClassNotFoundException
     */
    public function setPatentUse(?bool $allowed): self
    {
        $builder = (new PermissionModelBuilder())->name(Constants::KEY_PATENT_USE);
        if ($allowed !== null) {
            $builder->allowed($allowed);
        }
        $this->patentUse = $builder->build();
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
     * @param  bool|null $allowed
     * @return self
     * @throws ClassNotFoundException
     */
    public function setPrivateUse(?bool $allowed): self
    {
        $builder = (new PermissionModelBuilder())->name(Constants::KEY_PRIVATE_USE);
        if ($allowed !== null) {
            $builder->allowed($allowed);
        }
        $this->privateUse = $builder->build();
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
     * @return string
     */
    public function __toString(): string
    {
        return $this->internalName . ' as ' . $this->externalName;
    }
}
