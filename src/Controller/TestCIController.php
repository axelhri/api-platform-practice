<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestCIController extends AbstractController
{
	#[Route('/test/ci', name: 'app_test_ci')]
	public function index(): Response
	{
		return $this->render('test_ci/index.html.twig', [
			'controller_name' => 'TestCIController',
		]);
	}
}
