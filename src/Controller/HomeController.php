<?php

namespace App\Controller;

use App\Form\CountryFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/country", name="country")
     */
    public function country(Request $request): Response
    {
        $formCountry = $this->createForm(CountryFormType::class);
        $formCountry->handleRequest($request);
        if ($formCountry->isSubmitted() && $formCountry->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->render('home/country.html.twig', [ 'formCountry' => $formCountry->createView()]);
    }
}
