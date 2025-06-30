<?php

// Edit database configuration.

return [
    "host" => $_ENV['DATABASE_HOST'],
    "port" => $_ENV['DATABASE_PORT'],
    "user" => $_ENV['DATABASE_USER'],
    "password" => $_ENV['DATABASE_PASSWORD'],
    "dbname" => $_ENV['DATABASE_NAME'],
    "charset" => $_ENV['DATABASE_CHARSET']
];
