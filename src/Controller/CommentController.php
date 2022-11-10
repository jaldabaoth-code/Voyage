<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/comment", name="comment_")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $formComment = $this->createForm(CommentFormType::class, $comment);
        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            if ($this->getUser()) {
                $entityManager = $this->getDoctrine()->getManager();
                $comment->setUser($this->getUser());
                $entityManager->persist($comment);
                $entityManager->flush();
            }
        }
        $comments = $commentRepository->findAll();
        return $this->render('comment/index.html.twig', [
            'formComment' => $formComment->createView(),
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"POST"})
     */
    public function deleteComment(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }
        return $this->redirectToRoute('comment_index');
    }
}
