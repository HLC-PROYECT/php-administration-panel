<?php

namespace HLC\AP\Infrastructure;

use HLC\AP\Controller\Course\CourseController;
use HLC\AP\Controller\Login\LoginController;
use HLC\AP\Controller\Register\RegisterController;
use HLC\AP\Controller\Student\StudentController;
use HLC\AP\Controller\Task\TaskController;
use HLC\AP\Controller\Subject\SubjectController;
use HLC\AP\Domain\Course\CourseRepositoryInterface;
use HLC\AP\Domain\CourseTeacher\CourseTeacherRepositoryInterface;
use HLC\AP\Domain\Subject\subjectRepositoryInterface;
use HLC\AP\Domain\Task\TaskRepositoryInterface;
use HLC\AP\Domain\User\UserRepositoryInterface;
use HLC\AP\Repository\PdoCourseRepository;
use HLC\AP\Repository\PdoCourseTeacherRepository;
use HLC\AP\Repository\PdoSubjectRepository;
use HLC\AP\Repository\PdoTaskRepository;
use HLC\AP\Repository\PdoUserRepository;
use HLC\AP\Utils\DatabaseConnection;
use HLC\AP\Utils\ErrorsMessages;
use Psr\Container\ContainerInterface;

final class DependencyInjection
{
    public static function build(): array
    {
        return [
            DatabaseConnection::class => fn(ContainerInterface $container) => self::initDatabase(),
            ErrorsMessages::class => fn(ContainerInterface $container) => self::initErrors(),
            UserRepositoryInterface::class => fn(ContainerInterface $container) => self::initUserRepository($container),
            CourseRepositoryInterface::class => fn(ContainerInterface $container) => self::initCourseRepository($container),
            SubjectRepositoryInterface::class => fn(ContainerInterface $container) => self::initSubjectRepository($container),
            TaskRepositoryInterface::class => fn(ContainerInterface $container) => self::initTaskResponse($container),
            CourseTeacherRepositoryInterface::class => fn(ContainerInterface $container) => self::initCourseTeacherRepository($container),
            TaskController::class => fn(ContainerInterface $container) => self::initTaskController($container),
            LoginController::class => fn(ContainerInterface $container) => self::initLoginController($container),
            RegisterController::class => fn(ContainerInterface $container) => self::initRegisterController($container),
            CourseController::class => fn(ContainerInterface $container) => self::initCourseController($container),
            SubjectController::class => fn(ContainerInterface $container) => self::initSubjectController($container),
            StudentController::class => fn(ContainerInterface $container) => self::initStudentController($container)
        ];
    }

    private static function initLoginController(ContainerInterface $container): LoginController
    {
        return new LoginController(
            $container->get(UserRepositoryInterface::class),
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
            $container->get(UserRepositoryInterface::class),
            $container->get(SubjectRepositoryInterface::class),
            $container->get(TaskRepositoryInterface::class)
        );
    }

    public static function initCourseTeacherRepository(ContainerInterface $container): CourseTeacherRepositoryInterface
    {
        return new PdoCourseTeacherRepository($container->get(DatabaseConnection::class));
    }

    private static function initSubjectRepository(ContainerInterface $container): SubjectRepositoryInterface
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
        return new CourseController(
            $container->get(UserRepositoryInterface::class),
            $container->get(CourseRepositoryInterface::class),
            $container->get(CourseTeacherRepositoryInterface::class),
            $container->get(LoginController::class)
        );
    }

    private static function initErrors(): ErrorsMessages
    {
        return new ErrorsMessages();
    }

    private static function initSubjectController(ContainerInterface $container): SubjectController
    {
        return new SubjectController(
            $container->get(UserRepositoryInterface::class),
            $container->get(SubjectRepositoryInterface::class),
            $container->get(CourseRepositoryInterface::class)
        );
    }

    private static function initRegisterController(ContainerInterface $container): RegisterController
    {
        return new RegisterController(
            $container->get(UserRepositoryInterface::class),
            $container->get(CourseRepositoryInterface::class),
            $container->get(CourseController::class)
        );
    }

    private static function initStudentController(ContainerInterface $container): StudentController
    {
        return new StudentController(
            $container->get(UserRepositoryInterface::class),
            $container->get(LoginController::class),
        );
    }
}