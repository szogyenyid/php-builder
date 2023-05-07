<?php

namespace Test;

use Szogyenyid\PhpBuilder\Builder;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'vendor/autoload.php';

class User
{
    use Builder;

    private string $name;
    private int $age;
}

$user = User::builder()
    ->withFame('John')
    ->withAge(42)
    ->build();
var_dump($user);
