<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
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
    */
    public function students(Department $department)
    {
        return $department->getStudents();
    }
}
