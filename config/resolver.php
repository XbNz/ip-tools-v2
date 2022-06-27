<?php

return [
    'use_proxy' => false,
    'proxies' => [],

    'timeout' => 10,
    'cache_period' => 864000,

    'async_concurrent_requests' => 5,

    'use_retries' => true,
    'tries' => 5,
    'retry_sleep' => 3,
    'retry_sleep_multiplier' => 1.5,
];
