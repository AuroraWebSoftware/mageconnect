<?php

namespace Aurorawebsoftware\Mageconnect;

use Aurorawebsoftware\Mageconnect\Exceptions\CustomerAccessTokenMissingException;
use Aurorawebsoftware\Mageconnect\Exceptions\CustomerUnauthorizedException;
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
        private ?string $customerAccessToken = null,
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

    /**
     * @return $this
     */
    public function setCustomerAccessToken(string $token): static
    {
        $this->customerAccessToken = $token;

        return $this;
    }

    public function getCustomerAccessToken(): ?string
    {
        return $this->customerAccessToken;
    }

    /**
     * @param string $username
     * @param string $password
     * @return static
     * @throws Throwable
     */
public function loginCustomer(string $username, string $password): static
{
        $endpointUrl = $this->url . '/' . $this->basePath . '/' . $this->storeCode . '/' . $this->apiVersion .
            '/integration/customer/token';

        $response = Http::post($endpointUrl, [
            'username' => $username,
            'password' => $password
        ]);

        throw_if($response->status() == 400, new HttpResponseStatusException($response->body()));
        throw_if($response->status() == 401, new CustomerUnauthorizedException($response->body()));
        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $this->setCustomerAccessToken($response->json());
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
     * Creates a cart using guest api
     *
     * @throws Throwable
     */
    public function postGuestCart(): string
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts';

        $response = Http::post($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function getGuestCart(string $cartId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId;

        $response = Http::get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @return array|mixed
     *
     * @throws Throwable
     */
    public function postGuestCartItems(string $cartId, array $data): mixed
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/items';

        $response = Http::post($endpointUrl, $data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @throws Throwable
     */
    public function putGuestCartItems(string $cartId, int $itemId, array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/items/'.$itemId;

        $response = Http::put($endpointUrl, $data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param string $cartId
     * @param int $itemId
     * @return bool
     * @throws Throwable
     */
    public function deleteGuestCartItems(string $cartId, int $itemId): bool
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/items/'.$itemId;

        $response = Http::delete($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param string $cartId
     * @param array $data
     * @return integer
     * @throws Throwable
     */
    public function postGuestCartBillingAddress(string $cartId,array $data): int
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/billing-address';

        $response = Http::post($endpointUrl,$data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param string $cartId
     * @return array
     * @throws Throwable
     */
    public function getGuestCartBillingAddress(string $cartId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/billing-address';

        $response = Http::get($endpointUrl);
        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();


    }

    /**
     * @param string $cartId
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function putGuestCartCollectTotal(string $cartId,array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/collect-totals';


        $response = Http::put($endpointUrl,$data);
        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();

    }

    /**
     * @param string $cartId
     * @return array
     * @throws Throwable
     */
    public function getGuestCartCoupons(string $cartId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/coupons';

        $response = Http::get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param string $cartId
     * @return bool
     * @throws Throwable
     */
    public function deleteGuestCartCoupons(string $cartId): bool
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/coupons';

        $response = Http::delete($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param string $cartId
     * @param array $data
     * @return int
     * @throws Throwable
     */
    public function postGuestCartPaymentInformation(string $cartId, array $data): int
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/payment-information';

        $response = Http::post($endpointUrl,$data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();

    }


    /**
     * @param string $cartId
     * @return array
     * @throws Throwable
     *
     */
    public function getGuestCartPaymentInformation(string $cartId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/payment-information';

        $response = Http::get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();

    }

    /**
     * @param string $cartId
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function postGuestCartShippingInformation(string $cartId, array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/shipping-information';

        $response = Http::post($endpointUrl,$data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }


    /**
     * @param string $cartId
     * @return array
     * @throws Throwable
     */
    public function getGuestCartShippingMethods(string $cartId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/shipping-methods';

        $response = Http::get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param string $cartId
     * @return array
     */
    public function getGuestCartTotals(string $cartId): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/totals';

        $response = Http::get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();

    }

    /**
     * @param string $cartId
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function postGuestCartTotalsInformation(string $cartId, array $data): array
    {
        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/guest-carts/'.$cartId.'/totals-information';

        $response = Http::post($endpointUrl,$data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }



    /**
     * @throws Throwable
     */
    public function getCartMineTotals(): array
    {

        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.'/carts/mine/totals';

        $response = Http::withToken($this->customerAccessToken)->get($endpointUrl);

        throw_if($response->status() == 400, new HttpResponseStatusException($response->body()));
        throw_if($response->status() == 401, new CustomerUnauthorizedException($response->body()));

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();

    }


    /**
     * @return string
     * @throws Throwable
     */
    public function postMineCart(): string
    {
        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/carts/mine';

        $response = Http::withToken($this->customerAccessToken)->post($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function getMineCart(): array
    {
        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/carts/mine';

        $response = Http::withToken($this->customerAccessToken)->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function postMineCartItems(array $data): array
    {
        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/carts/mine/items';

        $response = Http::withToken($this->customerAccessToken)->post($endpointUrl, $data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @return array
     * @throws Throwable
     */
    public function getMineCartItems(): array
    {
        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/carts/mine/items';

        $response = Http::withToken($this->customerAccessToken)->get($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }


    /**
     * @param int $itemId
     * @param array $data
     * @return array
     * @throws Throwable
     */
    public function putMineCartItems(int $itemId, array $data): array
    {
        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/carts/mine/items/'.$itemId;

        $response = Http::withToken($this->customerAccessToken)->put($endpointUrl, $data);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

    /**
     * @param int $itemId
     * @return bool
     * @throws Throwable
     */
    public function deleteMineCartItems(int $itemId): bool
    {

        throw_if($this->customerAccessToken == null, new CustomerAccessTokenMissingException());

        $endpointUrl = $this->url.'/'.$this->basePath.'/'.$this->apiVersion.
            '/carts/mine/items/'.$itemId;
        $response = Http::withToken($this->customerAccessToken)->delete($endpointUrl);

        throw_if($response->status() != 200, new HttpResponseStatusException($response->body()));

        return $response->json();
    }

}
