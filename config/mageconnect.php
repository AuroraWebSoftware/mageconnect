<?php

// config for Aurorawebsoftware/Mageconnect
return [
    'magento_url' => env('MAGENTO_URL'),
    'magento_admin_access_token' => env('MAGENTO_ADMIN_ACCESS_TOKEN'),
    'magento_customer_access_token' => env('MAGENTO_CUSTOMER_ACCESS_TOKEN'),

    'magento_base_path' => env('MAGENTO_BASE_PATH', 'rest'),
    'magento_store_code' => env('MAGENTO_STORE_CODE', 'all'),
    'magento_api_version' => env('MAGENTO_API_VERSON','V1')
];
