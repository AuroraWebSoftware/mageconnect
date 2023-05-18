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
        private ?string $customerAccessToken = null, /** @phpstan-ignore-line */
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
        if ($key != 'searchCriteria') {
            $key = $prefix ? $prefix.'.'.$key : $key;
        }

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
     *
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
     *
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function getProduct(string|int $sku)
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products/'.$sku;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
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
            '/categories?'.$this->buildSearchCriteriaQuery();

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * id ye göre kategoriyi getirir
     *
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function getCategory(int $categoryId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/categories/'.$categoryId;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * Bir kategori içindeki ürünleri listeler
     *
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function getCategoriesProducts(int $categoryId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/categories/'.$categoryId.'/products';

        dump($endpointUrl);
        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * bir ürün ekler
     *
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function postProduct(array $data): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/products';

        $response = Http::withToken($this->adminAccessToken)
            ->post($endpointUrl, $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * sku su verilen ürünü günceller
     *
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function putProduct(string $sku, array $data): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products/'.$sku;

        $response = Http::withToken($this->adminAccessToken)
            ->put($endpointUrl, $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function deleteProduct(string $sku): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/products/'.$sku;

        $response = Http::withToken($this->adminAccessToken)
            ->delete($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function getOrders(): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/orders?'.$this->buildSearchCriteriaQuery();

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function getOrder($entityId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->storeCode.'/'.$this->apiVersion.
            '/orders/'.$entityId;

        $response = Http::withToken($this->adminAccessToken)
            ->get($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function deleteOrder(int $entityId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/orders/'.$entityId;

        dump($endpointUrl);
        $response = Http::withToken($this->adminAccessToken)
            ->delete($endpointUrl);

        dump($response->body());
        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function cancelOrder(int $entityId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/orders/'.$entityId.'/cancel';

        $response = Http::withToken($this->adminAccessToken)
            ->put($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function holdOrder(int $entityId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/orders/'.$entityId.'/hold';

        $response = Http::withToken($this->adminAccessToken)
            ->post($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function unHoldOrder(int $entityId): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/orders/'.$entityId.'/unhold';

        $response = Http::withToken($this->adminAccessToken)
            ->post($endpointUrl);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    /**
     * @return mixed
     *
     * @throws Throwable
     */
    public function refundOrder(int $entityId, array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/order/'.$entityId.'/refund';

        $response = Http::withToken($this->adminAccessToken)
            ->post($endpointUrl, $data);

        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }

    public function putOrders(int $entityId, array $data)
    {
        //todo tamamlanmadı

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/orders/'.$entityId;

        $response = Http::withToken($this->adminAccessToken)
            ->put($endpointUrl, $data);

        dump(json_decode($response->body()));
        throw_if($response->status() != 200, new \Exception($response->body()));

        // todo mixed dönemesi halinde yapılacaklar
        return $response->json();
    }
}
