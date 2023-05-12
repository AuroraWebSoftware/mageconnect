<?php

namespace Aurorawebsoftware\Mageconnect;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Throwable;

class MageconnectService
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
     * filter_groups.0.filters.0.field => 'name'
     * filter_groups.0.filters.0.value => 'value'
     * filter_groups.0.filters.0.condition_type => '%Leggings%'
     * pageSize => 'name'
     *
     * @return $this
     */
    public function addSearchCriteria(string $key, string|int|float $value, ?string $prefix = 'searchCriteria'): static
    {
        $key = $prefix ? $prefix.'.'.$key : $key;
        $this->searchCriterias[$key] = $value;

        return $this;
    }

    private function buildSearchCriteriaQuery(): string
    {

        if (! $this->searchCriterias) {
            return '';
        }

        $undottedSearchCriteria = Arr::undot($this->searchCriterias);
        $query = Arr::query($undottedSearchCriteria);

        return $query;

    }

    /**
     * tüm ürünleri listeler
     * @throws Throwable
     */
    public function getProducts(): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products?'.$this->buildSearchCriteriaQuery();

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * sku ya göre bir ürün getirir
     * @param string|int $sku
     * @return array|mixed
     * @throws Throwable
     */
    public function getProduct(string|int $sku){
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/' . $this->apiVersion .
            '/products/' . $sku;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * tüm kategorileri listeler
     * @return array
     * @throws Throwable
     */
    public function getCategories(): array
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/' . $this->apiVersion .
            '/categories?' . $this->buildSearchCriteriaQuery();

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * id ye göre kategoriyi getirir
     * @param int $categoryId
     * @return array|mixed
     * @throws Throwable
     */
    public function getCategory(int $categoryId): mixed
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/' . $this->apiVersion .
            '/categories/'.$categoryId;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * Bir kategori içindeki ürünleri listeler
     * @param int $categoryId
     * @return array|mixed
     * @throws Throwable
     */
    public function getCategoriesProducts(int $categoryId): mixed
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/' . $this->apiVersion .
            '/categories/'.$categoryId . "/products";

        dump($endpointUrl);
        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * bir ürün ekler
     * @param array $data
     * @return array|mixed
     * @throws Throwable
     */
    public function postProduct(array $data): mixed
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->apiVersion .
            '/products';

        $response = Http::withToken($this->adminAccessToken)
            ->post($endpointUrl , $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * sku su verilen ürünü günceller
     * @param $data
     * @return array|mixed
     * @throws Throwable
     */
    public function putProduct(string $sku, array $data): mixed
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/'. $this->apiVersion .
            '/products/'. $sku;

        $response = Http::withToken($this->adminAccessToken)
            ->put($endpointUrl , $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }


    /**
     * @param string $sku
     * @return array|mixed
     * @throws Throwable
     */
    public function deleteProduct(string $sku): mixed
    {
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/'. $this->apiVersion .
            '/products/'. $sku;

        $response = Http::withToken($this->adminAccessToken)
            ->delete($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }
}
