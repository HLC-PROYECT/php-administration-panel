<?php

require_once __DIR__ . '/../vendor/autoload.php';

use DI\ContainerBuilder;
use HLC\AP\Infrastructure\DependencyInjection;

ini_set('opcache.enabled', false);
session_start();

try {

    $builder = new ContainerBuilder();
    $builder->addDefinitions(DependencyInjection::build());
    $container = $builder->build();
    $URI = $_SERVER['REQUEST_URI'] ?? null;

    if (null !== $URI) {
        $explode = explode("/", $URI);
        $nameSpace = ucfirst($explode[1]);
        $class = ucfirst($nameSpace) . 'Controller';
        $class = "HLC\AP\Controller\\$nameSpace\\$class";
        $method = $explode[2] ?? 'execute';

        if (false !== $container->has($class)) {
            $controller = $container->get($class);
            $controller->$method();
            set_url("$nameSpace");
            return;
        }
        navigateTo404();
    }
} catch (Exception $e) {
    var_dump($e);
}

function navigate($container, string $class): void
{
    $_SERVER['REQUEST_URI'] = "/$class";
    set_url("$class");
    $controller = $container->get("HLC\AP\Controller\\$class");
    $controller->execute();
}

function set_url($url)
{
    $_SERVER['REQUEST_URI'] = "/$url";
    echo("<script>history.replaceState({},'','/$url');</script>");
}

function navigateTo404()
{
    set_url('404');
    require __DIR__ . '/../src/Views/404/404.php';
}