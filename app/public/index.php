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
    $folder = ucfirst($explode[1]);
    $classStr = $folder . 'Controller';
    $class = ucfirst($classStr);

    if (isValidUri($explode)) {
        if (isComplexUri($explode)) {
            if ($container->has("HLC\AP\Controller\\$explode[1]\\$explode[2]\\$explode[2]Controller")) {
                navigateComplex($container, $explode[1], $explode[2]);
            } else navigateTo404();
        } else {
            if ($container->has("HLC\AP\Controller\\$folder\\" . $class)) {
                navigate($container, $folder, $class);
            } elseif (empty(trim($explode[1]))) {
                if (isset($_COOKIE['loggedId'])) {
                    navigate($container, "Course", "CourseController");
                } else {
                    navigate($container, "Login", "LoginController");
                }
            } else navigateTo404();
        }
    } else navigateTo404();

}

function isComplexUri($endPoint): bool
{
    return sizeof($endPoint) === 3;
}

function isValidUri($endPoint): bool
{
    return isComplexUri($endPoint) || sizeof($endPoint) === 2;
}

function navigate($container, string $folder, string $class): void
{
    $_SERVER['REQUEST_URI'] = "/$folder";
    set_url("$folder");
    $controller = $container->get("HLC\AP\Controller\\$folder\\$class");
    $controller->execute();
}

function navigateComplex($container, string $folder, string $class): void
{
    set_url("$class");
    $_SERVER['REQUEST_URI'] = "/$class";
    $controller = $container->get("HLC\AP\Controller\\$folder\\$class\\$class" . "Controller");
    $controller->execute();
}

//BY isGood ? "Jose" : "Victor";
function set_url($url)
{
    echo("<script>history.replaceState({},'','/$url');</script>");
}

function navigateTo404()
{
    set_url('404');
    require __DIR__ . '/../src/views/404/404.php';
}