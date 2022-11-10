<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoFormType;
use App\Repository\PhotoRepository;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/photo", name="photo_")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("", name="index")
     */
    public function index(Request $request, PhotoRepository $photoRepository): Response
    {
        $photo = new Photo();
        $formPhoto = $this->createForm(PhotoFormType::class, $photo);
        $formPhoto->handleRequest($request);
        if ($formPhoto->isSubmitted() && $formPhoto->isValid()) {
            if ($this->getUser()) {
                $entityManager = $this->getDoctrine()->getManager();
                $photo->setUser($this->getUser());
                $entityManager->persist($photo);
                $entityManager->flush();
            }
        }
        $photos = $photoRepository->findAll();
        return $this->render('photo/index.html.twig', [
            'formPhoto' => $formPhoto->createView(),
            'photos' => $photos
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"POST"})
     */
    public function deletePhoto(Request $request, Photo $photo): Response
    {
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->request->get('_token'))) {
            $fileName = $photo->getPhoto();
            $fileSystem = new Filesystem();
            $fileSystem->remove('%upload_directory%/public/uploads/' . $fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($photo);
            $entityManager->flush();
        }
        return $this->redirectToRoute('photo_index');
    }
}
