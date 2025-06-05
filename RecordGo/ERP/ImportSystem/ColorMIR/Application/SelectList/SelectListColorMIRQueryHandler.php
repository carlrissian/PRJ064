<?php

namespace ImportSystem\ColorMIR\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\ColorMIR\Domain\ColorMIRCriteria;
use ImportSystem\ColorMIR\Domain\ColorMIRRepository;

class SelectListColorMIRQueryHandler
{
    /**
     * @var ColorMIRRepository
     */
    private $colorMIRRepository;

    /**
     * SelectListColorMIRQueryHandler constructor.
     *
     * @param ColorMIRRepository $colorMIRRepository
     */
    public function __construct(ColorMIRRepository $colorMIRRepository)
    {
        $this->colorMIRRepository = $colorMIRRepository;
    }

    /**
     * @return SelectListColorMIRResponse
     */
    public function handle(): SelectListColorMIRResponse
    {
        $ColorMIRCollection = $this->colorMIRRepository->getBy(new ColorMIRCriteria())->getCollection();
        return new SelectListColorMIRResponse(Utils::createSelect($ColorMIRCollection));
    }
}
