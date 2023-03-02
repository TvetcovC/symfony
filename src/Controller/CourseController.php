<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    #[Route('/course/view/{id<\d+>}', name: 'app_course')] 
    public function showSingle(int $id, CourseRepository $courseRepository): Response
    {
        $course = $courseRepository->find($id);

        if (!$course) {
            return new Response("<h1>Course `{$id}` not found in list</h1><h2><a href='/'>To main Page</a></h2>");
        }

        return $this->render('course/index.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/course', name: 'app_course_list')]
    public function showAll(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll(); 
        
        return $this->render('course/list.html.twig', [
            'courses' => $courses,
        ]); 
    }

    #[Route('/course/create', name: 'app_course_create')]
    public function create(Request $request, CourseRepository $courseRepository): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course = $form->getData();
            $courseRepository->save($course, true);
            return $this->redirectToRoute('app_course_list');
        }

        return $this->renderForm('course/form.html.twig', [
            'form' => $form,
            'course' => $course,
        ]);
    }

    #[Route('/course/update/{id}', name: 'app_course_update')] 
    public function update(int $id, Request $request, CourseRepository $courseRepository): Response
    { 
        $course = $courseRepository->find($id);

        if (!$course) { 
            return new Response("<h1>Course `{$id}` not found in list</h1><h2><a href='/'>To main Page</a></h2>");
        }

        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $course = $form->getData();
            $courseRepository->save($course, true);
            return $this->redirectToRoute('app_course_list');
        }

        return $this->renderForm('course/form.html.twig', [
            'form' => $form,
            'course' => $course,
        ]);
    }

    #[Route('/course/delete/{id}', name: 'app_course_delete')]// delete
    public function delete(int $id,  CourseRepository $courseRepository, LoggerInterface $logger): Response
    { 
        $course = $courseRepository->find($id);

        if (!$course) {
            return new Response("<h1>Course `{$id}` not found in list</h1><h2><a href='/'>To main Page</a></h2>");
        }

        $courseRepository->remove($course, true);

        $logger->warning("Course {$id} was permanently removed");

        return $this->redirectToRoute('app_course_list');
    }
}
