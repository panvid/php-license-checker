<?php
declare(strict_types=1);

namespace LicenseChecker\Model;

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

    /** @var string[] Conditions key & description */
    private $commercialUse = [Conditions::UNDEFINED => ''];

    /** @var string[] Conditions key & description */
    private $modification = [Conditions::UNDEFINED => ''];

    /** @var string[] Conditions key & description */
    private $distribution = [Conditions::UNDEFINED => ''];

    /** @var string[] Conditions key & description */
    private $privateUse = [Conditions::UNDEFINED => ''];

    /** @var string[] Conditions key & description */
    private $liability = [Conditions::UNDEFINED => ''];

    /** @var string[] Conditions key & description */
    private $warranty = [Conditions::UNDEFINED => ''];

    /** @var string[] Conditions key & description */
    private $conditions = [Conditions::UNDEFINED => ''];

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
     * @return string[]
     */
    public function getCommercialUse(): array
    {
        return $this->commercialUse;
    }

    /**
     * @param  string[] $commercialUse
     * @return self
     */
    public function setCommercialUse(array $commercialUse): self
    {
        $this->commercialUse = $commercialUse;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getModification(): array
    {
        return $this->modification;
    }

    /**
     * @param  string[] $modification
     * @return self
     */
    public function setModification(array $modification): self
    {
        $this->modification = $modification;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getDistribution(): array
    {
        return $this->distribution;
    }

    /**
     * @param  string[] $distribution
     * @return self
     */
    public function setDistribution(array $distribution): self
    {
        $this->distribution = $distribution;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getPrivateUse(): array
    {
        return $this->privateUse;
    }

    /**
     * @param  string[] $privateUse
     * @return self
     */
    public function setPrivateUse(array $privateUse): self
    {
        $this->privateUse = $privateUse;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getLiability(): array
    {
        return $this->liability;
    }

    /**
     * @param  string[] $liability
     * @return self
     */
    public function setLiability(array $liability): self
    {
        $this->liability = $liability;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getWarranty(): array
    {
        return $this->warranty;
    }

    /**
     * @param  string[] $warranty
     * @return self
     */
    public function setWarranty(array $warranty): self
    {
        $this->warranty = $warranty;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getConditions(): array
    {
        return $this->commercialUse;
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
