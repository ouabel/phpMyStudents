<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DepartmentRepository;
use App\Entity\Department;
use App\Form\DepartmentType;

/**
 * @Route("/department")
*/
class DepartmentController
{

    private $twig;
    private $departmentRepository;
    private $formFactory;
    private $entityManager;
    private $router;

    public function __construct(
        \Twig_Environment $twig,
        DepartmentRepository $departmentRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->departmentRepository = $departmentRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @Route("/", name="department_index")
    */
    public function index()
    {
        $html = $this->twig->render('department/index.html.twig',[
            'departments' => $this->departmentRepository->findAll()
        ]);
        return new Response($html);
    }

    /**
     * @Route("/add", name="department_add")
    */
    public function add(Request $request)
    {
        $department = new Department();
        $form = $this->formFactory->create(DepartmentType::class, $department);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($department);
            $this->entityManager->flush();

            return new RedirectResponse(
                $this->router->generate('department_index')
            );
        }

        $html = $this->twig->render('department/add.html.twig',[
            'form' => $form->createView()
        ]);
        return new Response($html);
    }

    /**
     * @Route("/show/{id}", name="department_show")
    */
    public function show(Department $department)
    {
        if (!$department) {
            throw $this->createNotFoundException('Department does not exist');
        }
                $html = $this->twig->render('department/show.html.twig',[
            'department' => $department
        ]);
        return new Response($html);
    }

    /**
     * @Route("/edit/{id}", name="department_edit")
    */
    public function edit(Department $department, Request $request)
    {
        if (!$department) {
            throw $this->createNotFoundException('Department does not exist');
        }
        $form = $this->formFactory->create(DepartmentType::class, $department);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($department);
            $this->entityManager->flush();
        }

        $html = $this->twig->render('department/edit.html.twig',[
            'form' => $form->createView()
        ]);
        return new Response($html);
    }

    /**
     * @Route("/delete/{id}", name="department_delete")
    */
    public function delete(Department $department)
    {
        if (!$department) {
            throw $this->createNotFoundException('Department does not exist');
        }
        $this->entityManager->remove($department);
        $this->entityManager->flush();

        return new RedirectResponse(
            $this->router->generate('department_index')
        );
    }
}
