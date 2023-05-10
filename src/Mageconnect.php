<?php

namespace Aurorawebsoftware\Mageconnect;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class Mageconnect
{
    private ?array $searchCriterias = null;

    public function __construct(
        private string $url,
        private ?string $adminAccessToken = null,
        private ?string $customerAccessToken = null,
        private ?string $basePath = null,
        private ?string $storeCode = null,
        private ?string $apiVersion = null,
    ) {
    }

    /**
     * @param  string  $condition
     * @param  string  $value
     * @return $this
     */
    public function addSearchCriteria(string $key, string|int|float $value): static
    {

        // filter_groups.0.filters.0.field => 'name'
        // filter_groups.0.filters.0.value => 'value'
        // filter_groups.0.filters.0.condition_type => '%Leggings%'

        // pageSize => 'name'

        $this->searchCriterias[$key] = $value;

        return $this;
    }

    private function buildSearchCriteriaQuery(): string
    {

        /*
        $searchCriteaArray = array_map(function ($key, $value) {
            explode($key)
        }, $this->searchCriterias);
        */

        $undottedSearchCriteria = Arr::undot($this->searchCriterias);
        $query = Arr::query($undottedSearchCriteria);

        return '';

    }

    /**
     * @return array|mixed
     *
     * @throws \Throwable
     */
    public function products()
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products?'.$this->buildSearchCriteriaQuery();

        $productsResponse = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl.'&'.'searchCriteria[pageSize]=20');

        throw_if($productsResponse->status() != 200, new \Exception('Exception'));

        return $products->json();

    }
}
