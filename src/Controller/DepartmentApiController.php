<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Swagger\Annotations as SWG;
use App\Entity\Department;
use App\Repository\DepartmentRepository;

/**
 * @Route("/api/department")
*/
class DepartmentApiController
{
    public function __construct(DepartmentRepository $departmentRepository)
    {
		$this->departmentRepository = $departmentRepository;
    }

    /**
     * @Get(
     * path = "/",
     * name = "api_department_list"
     * )
     * @View
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of all departments",
     * )
     */
    public function list()
    {
        return $this->departmentRepository->findAll();
    }

    /**
     * @Get(
     * path = "/{id}/students",
     * name = "api_department_students",
     * requirements = {"id"="\d+"}
     * )
     * @View
     * @SWG\Response(
     *     response=200,
     *     description="Returns a list of students under a department",
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The ID of department"
     * )
     */
    public function students(Department $department)
    {
        return $department->getStudents();
    }
}
