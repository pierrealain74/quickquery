<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(QuestionRepository $questionRepository): Response
    {

        $dataQuestion = $questionRepository->findAllWithParticipants();

        return $this->render('pages/home/index.html.twig', [
            "dataQuestion" => $dataQuestion,
        ]);
    }
}
