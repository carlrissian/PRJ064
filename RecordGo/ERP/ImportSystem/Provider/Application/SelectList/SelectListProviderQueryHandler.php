<?php

namespace ImportSystem\Provider\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\Provider\Domain\ProviderCriteria;
use ImportSystem\Provider\Domain\ProviderRepository;

class SelectListProviderQueryHandler
{
    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * SelectListProviderQueryHandler constructor.
     *
     * @param ProviderRepository $providerRepository
     */
    public function __construct(ProviderRepository $providerRepository)
    {
        $this->providerRepository = $providerRepository;
    }

    /**
     * @return SelectListProviderResponse
     */
    public function handle(): SelectListProviderResponse
    {
        $providerCollection = $this->providerRepository->getBy(new ProviderCriteria())->getCollection();
        return new SelectListProviderResponse(Utils::createCustomSelectList($providerCollection, 'id', 'providerSAPId', 'customerSAPId', 'name'));
    }
}
