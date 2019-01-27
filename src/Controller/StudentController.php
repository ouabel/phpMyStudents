<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\FormFactoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\StudentRepository;
use App\Entity\Student;
use App\Form\StudentType;

/**
 * @Route("/student")
*/
class StudentController
{

    private $twig;
    private $studentRepository;
    private $formFactory;
    private $entityManager;
    private $router;

    public function __construct(
        \Twig_Environment $twig,
        StudentRepository $studentRepository,
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        RouterInterface $router
    )
    {
        $this->twig = $twig;
        $this->studentRepository = $studentRepository;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    /**
     * @Route("/", name="student_index")
    */
    public function index()
    {
        $html = $this->twig->render('student/index.html.twig',[
            'students' => $this->studentRepository->findAll()
        ]);
        return new Response($html);
    }

    /**
     * @Route("/add", name="student_add")
    */
    public function add(Request $request)
    {
        $student = new Student();
        $form = $this->formFactory->create(StudentType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($student);
            $this->entityManager->flush();

            return new RedirectResponse(
                $this->router->generate('student_index')
            );
        }

        $html = $this->twig->render('student/add.html.twig',[
            'form' => $form->createView()
        ]);
        return new Response($html);
    }

    /**
     * @Route("/show/{id}", name="student_show")
    */
    public function show(Student $student)
    {
        $html = $this->twig->render('student/show.html.twig',[
            'student' => $student
        ]);
        return new Response($html);
    }

    /**
     * @Route("/edit/{id}", name="student_edit")
    */
    public function edit(Student $student, Request $request)
    {
        $form = $this->formFactory->create(StudentType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($student);
            $this->entityManager->flush();
        }

        $html = $this->twig->render('student/edit.html.twig',[
            'form' => $form->createView()
        ]);
        return new Response($html);
    }
    /**
     * @Route("delete/{id}", name="student_delete")
    */
    public function delete(Student $student)
    {
        $this->entityManager->remove($student);
        $this->entityManager->flush();

        return new RedirectResponse(
            $this->router->generate('student_index')
        );
    }
}
