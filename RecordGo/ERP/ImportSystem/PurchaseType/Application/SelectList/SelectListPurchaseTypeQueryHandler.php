<?php

namespace ImportSystem\PurchaseType\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\PurchaseType\Domain\PurchaseTypeCriteria;
use ImportSystem\PurchaseType\Domain\PurchaseTypeRepository;

class SelectListPurchaseTypeQueryHandler
{
    /**
     * @var PurchaseTypeRepository
     */
    private $purchaseTypeRepository;

    /**
     * SelectListPurchaseTypeQueryHandler constructor.
     *
     * @param PurchaseTypeRepository $purchaseTypeRepository
     */
    public function __construct(PurchaseTypeRepository $purchaseTypeRepository)
    {
        $this->purchaseTypeRepository = $purchaseTypeRepository;
    }

    /**
     * @return SelectListPurchaseTypeResponse
     */
    public function handle(): SelectListPurchaseTypeResponse
    {
        $purchaseTypeCollection = $this->purchaseTypeRepository->getBy(new PurchaseTypeCriteria())->getCollection();
        return new SelectListPurchaseTypeResponse(Utils::createSelect($purchaseTypeCollection));
    }
}
