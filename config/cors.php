<?php
return [
    'paths' => ['api/*'],  // Add your API routes and CSRF route here
    'allowed_methods' => ['*'],  // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)
    'allowed_origins' => ['http://localhost:3000',],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,  // Make sure this is true
];


?>
