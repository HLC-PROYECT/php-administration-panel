<?php
namespace Course;
interface CourseRespositoryInterface
{
    public function save(int $courseId, string $centroEd, int $año_inicio, int $año_fin, string $descript):bool;
    public function delete(int $courseId):bool;
    public function getById(int $courseId):Course;
    public function getAllCourses(): Array;
}