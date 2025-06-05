<?php

namespace ImportSystem\Location\Domain;

final class Branch
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $branchIATA;

    /**
     * @var integer|null
     */
    private $branchGroupId;

    /**
     * Branch constructor
     *
     * @param integer $id
     * @param string|null $name
     * @param string|null $branchIATA
     * @param integer|null $branchGroupId
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $branchIATA = null,
        ?int $branchGroupId = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->branchIATA = $branchIATA;
        $this->branchGroupId = $branchGroupId;
    }

    /**
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getBranchIATA(): ?string
    {
        return $this->branchIATA;
    }

    /**
     * @return integer|null
     */
    public function getBranchGroupId(): ?int
    {
        return $this->branchGroupId;
    }


    /**
     * @param array|null $branchArray
     * @return self
     */
    public static function createFromArray(?array $branchArray): self
    {
        return new self(
            intval($branchArray['ID']),
            $branchArray['BRANCHINTNAME'] ?? null,
            $branchArray['BRANCHIATA'] ?? null,
            isset($branchArray['GROUP']) && is_numeric($branchArray['GROUP'])
                ? intval($branchArray['GROUP']['ID'])
                : (isset($branchArray['BRANCHGROUPID']) && is_numeric($branchArray['BRANCHGROUPID']) ? intval($branchArray['BRANCHGROUPID']) : null)
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'BRANCHINTNAME' => $this->getName(),
            'BRANCHIATA' => $this->getBranchIATA(),
            'BRANCHGROUPID' => $this->getBranchGroupId(),
        ];
    }
}
