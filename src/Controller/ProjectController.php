<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    #[Route('/projects', name: 'app_project_list', methods: ['GET'])]
    public function index(ProjectRepository $repository): Response
    {
        $projects = $repository->findAll();
        return $this->render('project/list_projects.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/projects/{id}', name: 'app_project_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showProject(Project $project): Response
    {
        return $this->render('project/show_project.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/projects/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function newProject(): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectFormType::class, $project);

        return $this->render('project/new_project.html.twig', [
            'form' => $form,
        ]);
    }
}
