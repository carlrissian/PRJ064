<?php

namespace ImportSystem\Fleet\Domain;

final class Anexo1Head
{
    private ?int $anexo1Year;
    private ?string $anexo1IntRef;

    /**
     * @param int|null $anexo1Year
     * @param string|null $anexo1IntRef
     */
    public function __construct(?int $anexo1Year, ?string $anexo1IntRef)
    {
        $this->anexo1Year = $anexo1Year;
        $this->anexo1IntRef = $anexo1IntRef;
    }

    public function getAnexo1Year(): ?int
    {
        return $this->anexo1Year;
    }

    public function getAnexo1IntRef(): ?string
    {
        return $this->anexo1IntRef;
    }


    /**
     * @param array $anexo1HeadArray
     * @return self
     */
    public static function createFromArraySAP(array $anexo1HeadArray): self
    {
        return new self(
            isset($anexo1HeadArray['ANEXO1YEAR']) ? intval($anexo1HeadArray['ANEXO1YEAR']) : null,
            $anexo1HeadArray['ANEXO1INTREF'] ?? null
        );
    }
}
