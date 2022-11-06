<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(Request $request, CommentRepository $commentRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $entityManager = $this->getDoctrine()->getManager();
                $comment->setUser($this->getUser());
                $entityManager->persist($comment);
                $entityManager->flush();
            }
        }
        $comments = $commentRepository->findAll();
        return $this->render('comment/index.html.twig', [
            'commentForm' => $form->createView(),
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("comment/delete/{id}", name="delete_comment", methods={"POST"})
     */
    public function deleteComment(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete' . $comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
            $this->addFlash('danger', 'The program is deleted');
        }
        return $this->redirectToRoute('comment');
    }
}
