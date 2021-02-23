<?php

namespace HLC\AP\Infrastructure;

use HLC\AP\Controller\Course\CourseController;
use HLC\AP\Controller\Login\LoginController;
use HLC\AP\Controller\Task\TaskController;
use HLC\AP\Controller\Task\TaskInsert\TaskInsertController;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\CourseTeacher\CourseTeacherRepositoryInterface;
use HLC\AP\Domain\Subject\subjectRepositoryInterface;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Domain\TaskSubject\TaskSubjectRepositoryInterface;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Repository\PdoCourseRepository;
use HLC\AP\Repository\PdoCourseTeacherRepository;
use HLC\AP\Repository\PdoSubjectRepository;
use HLC\AP\Repository\PdoTaskRepository;
use HLC\AP\Repository\PdoTaskSubjectRepository;
use HLC\AP\Repository\PdoUserRepository;
use HLC\AP\Utils\DatabaseConnection;
use HLC\AP\Utils\ErrorsMessages;
use Psr\Container\ContainerInterface;

final class DependencyInjection
{
    public static function build(): array
    {
        return [
            DatabaseConnection::class =>
                fn(ContainerInterface $container) => self::initDatabase(),

            ErrorsMessages::class =>
                fn(ContainerInterface $container) => self::initErrors(),

            UserRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initUserRepository($container),
                
            CourseRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initCourseRepository($container),

            TaskRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initTaskResponse($container),

            SubjectRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initSubjectRespository($container),

            TaskSubjectRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initTaskSubjectRespository($container),

            CourseTeacherRepositoryInterface::class =>
                fn(ContainerInterface $container) => self::initCourseTeacherRepository($container),

            TaskController::class =>
                fn(ContainerInterface $container) => self::initTaskController($container),

            TaskInsertController::class =>
                fn(ContainerInterface $container) => self::initTaskInsertController($container),

            CourseController::class =>
                fn(ContainerInterface $container) => self::initCourseController($container),

            CourseInsertController::class =>
                fn(ContainerInterface $container) => self::initCourseInsertController($container),

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

    public static function initCourseTeacherRepository(ContainerInterface $container): CourseTeacherRepositoryInterface
    {
        return new PdoCourseTeacherRepository($container->get(DatabaseConnection::class));
    }

    private static function initSubjectRespository(ContainerInterface $container): SubjectRepositoryInterface
    {
        return new PdoSubjectRepository($container->get(DatabaseConnection::class));
    }

    private static function initTaskResponse(ContainerInterface $container): TaskRepositoryInterface
    {
        return new PdoTaskRepository($container->get(DatabaseConnection::class));
    }

    private static function initCourseRepository(ContainerInterface $container): CourseRepositoryInterface
    {
        return new PdoCourseRepository($container->get(DatabaseConnection::class));
    }

    private static function initCourseController(ContainerInterface $container): CourseController
    {
        return new CourseController($container->get(UserRepositoryInterface::class), $container->get(CourseRepositoryInterface::class));
    }

    private static function initTaskInsertController(ContainerInterface $container): TaskInsertController
    {
        return new TaskInsertController($container->get(ErrorsMessages::class), $container->get(PdoTaskRepository::class));
    }

    private static function initCourseInsertController(ContainerInterface $container)
    {
        return new CourseInsertController(
            $container->get(ErrorsMessages::class), 
            $container->get(CourseRepositoryInterface::class),
            $container->get(CourseTeacherRepositoryInterface::class)
        );
    }

    private static function initErrors(): ErrorsMessages
    {
        return new ErrorsMessages();
    }


}