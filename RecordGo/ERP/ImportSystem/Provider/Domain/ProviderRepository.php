<?php

namespace ImportSystem\Provider\Domain;

interface ProviderRepository
{
    /**
     * @param ProviderCriteria $criteria
     * @return ProviderGetByResponse
     */
    public function getBy(ProviderCriteria $criteria): ProviderGetByResponse;

    /**
     * @param int $id
     * @return Provider|null
     */
    // public function getById(int $id): ?Provider;

    /**
     * @param Provider $Provider
     * @return Provider|null
     */
    // public function store(Provider $Provider): ?int;

    /**
     * @param Provider $Provider
     * @return Provider|null
     */
    // public function update(Provider $Provider): ?int;
}
