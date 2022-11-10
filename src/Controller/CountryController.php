<?php

namespace App\Controller;

use App\Form\CountryFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/country", name="country_")
 */
class CountryController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request): Response
    {
        $formCountry = $this->createForm(CountryFormType::class);
        $formCountry->handleRequest($request);
        if ($formCountry->isSubmitted() && $formCountry->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        }
        return $this->render('country/index.html.twig', [ 'formCountry' => $formCountry->createView()]);
    }
}
