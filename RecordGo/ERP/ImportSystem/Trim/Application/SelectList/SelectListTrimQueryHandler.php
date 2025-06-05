<?php

namespace ImportSystem\Trim\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\Trim\Domain\TrimCriteria;
use ImportSystem\Trim\Domain\TrimRepository;

class SelectListTrimQueryHandler
{
    /**
     * @var TrimRepository
     */
    private $modelRepository;

    /**
     * SelectListTrimQueryHandler constructor.
     *
     * @param TrimRepository $modelRepository
     */
    public function __construct(TrimRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @return SelectListTrimResponse
     */
    public function handle(): SelectListTrimResponse
    {
        $modelCollection = $this->modelRepository->getBy(new TrimCriteria())->getCollection();
        return new SelectListTrimResponse(Utils::createCustomSelectList($modelCollection, 'id', 'name', 'model.id'));
    }
}
