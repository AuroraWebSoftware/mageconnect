<?php

namespace Aurorawebsoftware\Mageconnect;

use Aurorawebsoftware\Mageconnect\Exceptions\HttpResponseContentException;
use Aurorawebsoftware\Mageconnect\Exceptions\HttpResponseStatusException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Throwable;

class MageconnectService
{
    private ?array $criterias = null;

    public function __construct(
        private readonly string $url,
        private readonly string $adminAccessToken,
        private readonly string $basePath,
        private readonly string $storeCode,
        private readonly string $apiVersion,
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
    public function criteria(string $key, string|int|float $value, ?string $prefix = 'searchCriteria'): static
    {
        $key = $prefix ? $prefix.'.'.$key : $key;
        $this->criterias[$key] = $value;

        return $this;
    }

    private function buildCriteriaQuery(): string
    {

        if (! $this->criterias) {
            return '';
        }

        $undottedSearchCriteria = Arr::undot($this->criterias);
        $query = Arr::query($undottedSearchCriteria);

        return $query;
    }

    /**
     * tüm ürünleri listeler
     *
     * @throws Throwable
     */
    public function getProducts(int $pageSize = 20): array
    {
        $this->criteria('pageSize', $pageSize);

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products?'.$this->buildCriteriaQuery();

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * sku ya göre bir ürün getirir
     *
     * @throws Throwable
     */
    public function getProduct(string $sku): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products/'.$sku;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * tüm kategorileri listeler
     *
     * @throws Throwable
     */
    public function getCategories(): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/categories?'.$this->buildCriteriaQuery();

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * id ye göre kategoriyi getirir
     *
     *
     * @throws Throwable
     */
    public function getCategory(int $categoryId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/categories/'.$categoryId;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * Bir kategori içindeki ürünleri listeler
     *
     *
     * @throws Throwable
     */
    public function getCategoriesProducts(int $categoryId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/categories/'.$categoryId.'/products';

        dump($endpointUrl);
        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * bir ürün ekler
     *
     *
     * @throws Throwable
     */
    public function postProduct(array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/products';

        $response = Http::withToken($this->adminAccessToken)
            ->post($endpointUrl, $data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * sku su verilen ürünü günceller
     *
     *
     * @throws Throwable
     */
    public function putProduct(string $sku, array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products/'.$sku;

        $response = Http::withToken($this->adminAccessToken)
            ->put($endpointUrl, $data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_array($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function deleteProduct(string $sku): bool
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products/'.$sku;

        $response = Http::withToken($this->adminAccessToken)
            ->delete($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));
        throw_if(! is_bool($response->json()), new HttpResponseContentException($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function postCart(): string
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts';

        $response = Http::post($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function getCart(string $cardId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cardId;

        $response = Http::get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        return $response->json();
    }

    /**
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function postCartItems(string $cartId, array $data): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/items';

        $response = Http::post($endpointUrl, $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function putCartItems(string $cartId, int $itemId, array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/items/'.$itemId;

        $response = Http::put($endpointUrl, $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function deleteCartItems(string $cartId, int $itemId): bool
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/items/'.$itemId;

        $response = Http::delete($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        return $response->json();
    }
}
