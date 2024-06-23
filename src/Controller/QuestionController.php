<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Entity\QuestionTag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    #[Route('/question/add', name: 'question.add')]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $em, Security $security): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $tags = $form->get('tags')->getData();
            foreach ($tags as $tag) {
                $question->addTag($tag);
            }

            $em->persist($question);
            $em->flush();

            $this->addFlash(
                'success',
                'Votre question a été ajoutée'
            );

            return $this->redirectToRoute('home.index');
        }

        return $this->render('pages/question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
