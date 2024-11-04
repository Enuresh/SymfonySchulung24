<?php

namespace App\Controller;

use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
		$name = $request->query->get('name', 'World');

		return $this->render('main/index.html.twig', [
			'name' => $name,
		]);
    }

	#[Route('/contact', name: 'app_contact', methods: ['GET'])]
	#[Template('/main/contact.html.twig')]
	public function contact(Request $request): void
	{

	}
}
