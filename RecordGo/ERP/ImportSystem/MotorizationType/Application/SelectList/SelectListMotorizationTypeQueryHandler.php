<?php

namespace ImportSystem\MotorizationType\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\MotorizationType\Domain\MotorizationTypeCriteria;
use ImportSystem\MotorizationType\Domain\MotorizationTypeRepository;

class SelectListMotorizationTypeQueryHandler
{
    /**
     * @var MotorizationTypeRepository
     */
    private $motorizationTypeRepository;

    /**
     * SelectListMotorizationTypeQueryHandler constructor.
     *
     * @param MotorizationTypeRepository $motorizationTypeRepository
     */
    public function __construct(MotorizationTypeRepository $motorizationTypeRepository)
    {
        $this->motorizationTypeRepository = $motorizationTypeRepository;
    }

    /**
     * @return SelectListMotorizationTypeResponse
     */
    public function handle(): SelectListMotorizationTypeResponse
    {
        $motorizationTypeCollection = $this->motorizationTypeRepository->getBy(new MotorizationTypeCriteria())->getCollection();
        return new SelectListMotorizationTypeResponse(Utils::createCustomSelectList($motorizationTypeCollection, 'id', 'name', 'acrissLetter'));
    }
}
