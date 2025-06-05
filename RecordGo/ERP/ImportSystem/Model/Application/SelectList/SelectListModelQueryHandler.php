<?php

namespace ImportSystem\Model\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\Model\Domain\ModelCriteria;
use ImportSystem\Model\Domain\ModelRepository;

class SelectListModelQueryHandler
{
    /**
     * @var ModelRepository
     */
    private $modelRepository;

    /**
     * SelectListModelQueryHandler constructor.
     *
     * @param ModelRepository $modelRepository
     */
    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @return SelectListModelResponse
     */
    public function handle(): SelectListModelResponse
    {
        $modelCollection = $this->modelRepository->getBy(new ModelCriteria())->getCollection();
        return new SelectListModelResponse(Utils::createCustomSelectList($modelCollection, 'id', 'name', 'brand.id'));
    }
}
