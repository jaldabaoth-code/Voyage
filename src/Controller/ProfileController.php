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

/**
 * @Route("profile", name="profile_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{username}", name="index")
     * @ParamConverter("user", class="App\Entity\User"), options={"mapping": {"username": "username"}})
     */
    public function index(User $user): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/{username}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $formProfile = $this->createForm(ProfileFormType::class, $user);
        $formProfile->handleRequest($request);
        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('home');
        }
        if ($formProfile->isSubmitted() && $formProfile->isValid()) {
            // encode the plain password
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'formProfile' => $formProfile->createView()
        ]);
    }
}
