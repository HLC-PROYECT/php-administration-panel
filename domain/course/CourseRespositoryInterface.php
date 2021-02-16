<?php


namespace Course;


interface CourseRespositoryInterface
{
    public function save(Course $course):Course;
    public function delete(int $courseId):bool;
    public function getById(int $courseId):Course;
}