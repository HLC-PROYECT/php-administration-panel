<?php
require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use HLC\AP\Infrastructure\DependencyInjection;

ini_set('opcache.enabled', false);
session_start();

$builder = new ContainerBuilder();
$builder->addDefinitions(DependencyInjection::build());
$container = $builder->build();
$URI = $_SERVER['REQUEST_URI'] ?? null;

if (null !== $URI) {
    $explode = explode("/", $URI);
    $classStr = $explode[1] . 'Controller';
    $class = ucfirst($classStr);

    if ($container->has("HLC\AP\Controller\Login\\" . $class)) {
        $controller = $container->get("HLC\AP\Controller\Login\\" .$class);
        $controller->execute();
    }
}
