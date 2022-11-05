<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile/{userusername}", name="profile_show")
     * @ParamConverter("user", class="App\Entity\User"),
     * options={"mapping": {"userusername": "userusername"}})
     */
    public function index(User $user): Response
    {


        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("profile/{userusername}/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(ProfileFormType::class, $user);
        $form->handleRequest($request);
        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
