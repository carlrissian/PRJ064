<?php

namespace ImportSystem\SaleMethod\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\SaleMethod\Domain\SaleMethodCriteria;
use ImportSystem\SaleMethod\Domain\SaleMethodRepository;

class SelectListSaleMethodQueryHandler
{
    /**
     * @var SaleMethodRepository
     */
    private $saleMethodRepository;

    /**
     * SelectListSaleMethodQueryHandler constructor.
     *
     * @param SaleMethodRepository $saleMethodRepository
     */
    public function __construct(SaleMethodRepository $saleMethodRepository)
    {
        $this->saleMethodRepository = $saleMethodRepository;
    }

    /**
     * @return SelectListSaleMethodResponse
     */
    public function handle(): SelectListSaleMethodResponse
    {
        $saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
        return new SelectListSaleMethodResponse(Utils::createSelect($saleMethodCollection));
    }
}
