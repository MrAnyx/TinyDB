<?php

require __DIR__ . "/../vendor/autoload.php";

use MrAnyx\TinyDB;

$db = new TinyDB(__DIR__ . "/data.json");

$db->close();

//dd($db->getAll(TinyDB::TO_ARRAY));