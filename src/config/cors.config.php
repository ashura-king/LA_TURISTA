<?php

// Edit CORS configuration.

return [
    "origin" => "*",
    "allowed_methods" => [
        "GET",
        "POST",
        "PATCH",
        "DELETE",
        "OPTIONS"
    ],
    "allowed_headers" => [
        "Content-Type",
        "Authorization"
    ]
];
