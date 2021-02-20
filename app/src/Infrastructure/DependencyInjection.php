<?php

namespace HLC\AP\Infrastructure;

use HLC\AP\Controller\Login\LoginController;
use HLC\AP\Controller\Task\TaskController;
use HLC\AP\Domain\Subject\subjectRepositoryInterface;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Domain\TaskSubject\TaskSubjectRepositoryInterface;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Repository\PdoSubjectRepository;
use HLC\AP\Repository\PdoTaskRepository;
use HLC\AP\Repository\PdoTaskSubjectRepository;
use HLC\AP\Repository\PdoUserRepository;
use HLC\AP\Utils\DatabaseConnection;
use Psr\Container\ContainerInterface;

final class DependencyInjection
{
    public static function build(): array
    {
        return [
            DatabaseConnection::class =>
                fn(ContainerInterface $container) => self::initDatabase(),

            UserRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initUserRepository($container),

            TaskRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initTaskResponse($container),

            SubjectRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initSubjectRespository($container),

            TaskSubjectRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initTaskSubjectRespository($container),

            TaskController::class =>
                fn(ContainerInterface $container) => self::initTaskController($container),

            LoginController::class =>
                fn(ContainerInterface $container) => self::initLoginController($container)
        ];
    }

    private static function initLoginController(ContainerInterface $container): LoginController
    {
        return new LoginController(
            $container->get(PdoUserRepository::class),
            $container->get(TaskController::class)
        );
    }

    private static function initUserRepository(ContainerInterface $container): UserRepositoryInterface
    {
        return new PdoUserRepository($container->get(DatabaseConnection::class));
    }

    private static function initDatabase(): DatabaseConnection
    {
        return new DatabaseConnection();
    }

    private static function initTaskController(ContainerInterface $container): TaskController
    {
        return new TaskController(
            $container->get(PdoUserRepository::class),
            $container->get(PdoTaskSubjectRepository::class),
            $container->get(PdoSubjectRepository::class),
            $container->get(PdoTaskRepository::class)
        );
    }

    private static function initTaskSubjectRespository(ContainerInterface $container): TaskSubjectRepositoryInterface
    {
        return new PdoTaskSubjectRepository($container->get(DatabaseConnection::class));
    }

    private static function initSubjectRespository(ContainerInterface $container): SubjectRepositoryInterface
    {
        return new PdoSubjectRepository($container->get(DatabaseConnection::class));
    }

    private static function initTaskResponse(ContainerInterface $container): TaskRepositoryInterface
    {
        return new PdoTaskRepository($container->get(DatabaseConnection::class));
    }
}