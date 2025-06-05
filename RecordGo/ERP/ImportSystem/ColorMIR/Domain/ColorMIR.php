<?php

namespace ImportSystem\ColorMIR\Domain;

class ColorMIR
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $code;

    /**
     * @var string
     */
    private string $name;

    /**
     * ColorMIR constructor.
     * 
     * @param int $id
     * @param string|null $code
     * @param string $name
     */
    public function __construct(int $id, ?string $code, string $name)
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param integer $id
     * @param string|null $code
     * @param string $name
     * @return self
     */
    public static function create(int $id, ?string $code, string $name): self
    {
        return new self($id, $code, $name);
    }


    /**
     * @param array|null $colorMIRArray
     * @return self
     */
    public static function createFromArray(?array $colorMIRArray): self
    {
        return self::create(
            intval($colorMIRArray['ID']),
            $colorMIRArray['CODE'] ?? null,
            $colorMIRArray['DESCRIPTION'] ?? null
        );
    }
}
