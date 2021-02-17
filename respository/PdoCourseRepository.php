<?php
namespace Course;
require '../domain/course/CourseRespositoryInterface.php';

use Medoo\Medoo;


class PdoCourseRepository implements  CourseRespositoryInterface
{

    private Medoo $database;

    /**
     * PdoUserRepository constructor.
     */
    public function __construct()
    {
        $this->database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'instituto',
            'server' => 'db',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
        ]);
    }

    public function save(int $courseId, string $centroEd, int $año_inicio, int $año_fin, string $descript):bool
    {
        $response = $this->$database->insert("curso",
        [
        "codCurso" => $courseId,
        "centroed" => $centroEd,
        "año_ini" => $año_inicio,
        "año_fin" => $año_fin
        ]);

        return $response->errorCode() =='00000' ? true : false;

    }
    public function delete(int $courseId):bool
    {
        $response = $this->database->delete("curso", ["codCurso" => $courseId]);
        return $response->errorCode() == '00000' ? true : false;
    }

    public function getById(int $courseId):Course
    {
        return $this->database->select("curso", "*", ["codCurso" => $courseId])[0] ;

    }
    public function getAllCourses(): Array{
        return $this->database->select("curso", "*");
    }

}


?>