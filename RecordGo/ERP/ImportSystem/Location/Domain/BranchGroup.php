<?php

namespace ImportSystem\Location\Domain;

class BranchGroup
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * BranchGroup constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param array|null $branchGroupArray
     * @return self
     */
    public static function createFromArray(?array $branchGroupArray): self
    {
        return new self(
            intval($branchGroupArray['ID']),
            $branchGroupArray['BRANCHGROUPNAME'] ?? null
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'BRANCHGROUPNAME' => $this->getName(),
        ];
    }
}
