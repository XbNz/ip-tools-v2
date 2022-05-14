<?php

return [
    'use_proxy' => false,
    'proxies' => [],

    'timeout' => 2,
    'cache_period' => 864000,

    'async_concurrent_requests' => 10,

    'use_retries' => true,
    'tries' => 3,
    'retry_sleep' => 1,
    'retry_sleep_multiplier' => 1.5,
];
