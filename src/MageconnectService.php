<?php

namespace Aurorawebsoftware\Mageconnect;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Throwable;

class MageconnectService
{

    private ?array $searchCriterias = null;

    public function __construct(
        private string  $url,
        private ?string $adminAccessToken = null,
        private ?string $customerAccessToken = null,
        private ?string $basePath = null,
        private ?string $storeCode = null,
        private ?string $apiVersion = null,
    )
    {
    }


    /**
     * filter_groups.0.filters.0.field => 'name'
     * filter_groups.0.filters.0.value => 'value'
     * filter_groups.0.filters.0.condition_type => '%Leggings%'
     * pageSize => 'name'
     * @param string $key
     * @param string|int|float $value
     * @return $this
     */
    public function addSearchCriteria(string $key, string|int|float $value, ?string $prefix = 'searchCriteria'): static
    {
        $key = $prefix ? $prefix . '.' . $key : $key;
        $this->searchCriterias[$key] = $value;
        return $this;
    }

    private function buildSearchCriteriaQuery(): string
    {

        if (!$this->searchCriterias) return "";

        $undottedSearchCriteria = Arr::undot($this->searchCriterias);
        $query = Arr::query($undottedSearchCriteria);

        return $query;

    }

    /**
     * @return array
     * @throws Throwable
     */
    public function products(): array
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/' . $this->apiVersion .
            '/products?' . $this->buildSearchCriteriaQuery();

        $productsResponse = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($productsResponse->status() != 200, new \Exception('Exception'));

        // todo mixed dönemesi halinde yapılacaklar
        return $productsResponse->json();
    }


}
