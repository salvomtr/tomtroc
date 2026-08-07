<?php
if (!defined("DB_HOST")) {
    define("DB_HOST", '');
}
if (!defined("DB_NAME")) {
    define("DB_NAME", '');
}
if (!defined("DB_CHARSET")) {
    define("DB_CHARSET", '');
}
if (!defined("DB_USER")) {
    define("DB_USER", '');
}
if (!defined("DB_PASS")) {
    define("DB_PASS", '');
}

function getDB(): PDO {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

    return new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}