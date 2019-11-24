<?php

return [
    'db1' => [
        'dbname' => getenv('DB1_UUID'),
        'token' => getenv('DB1_TOKEN')
    ],
    'db2' => [
        'dbname' => getenv('DB2_UUID'),
        'token' => getenv('DB2_TOKEN')
    ],
];