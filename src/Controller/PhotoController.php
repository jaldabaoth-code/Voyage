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

class PhotoController extends AbstractController
{
    /**
     * @Route("/photo", name="photo")
     */
    public function index(Request $request, PhotoRepository $photoRepository): Response
    {
        $photo = new Photo();
        $form = $this->createForm(PhotoFormType::class, $photo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()) {
                $entityManager = $this->getDoctrine()->getManager();
                $photo->setUser($this->getUser());
                $entityManager->persist($photo);
                $entityManager->flush();
            }
        }

        $photos = $photoRepository->findAll();

        return $this->render('photo/index.html.twig', [
            'photoForm' => $form->createView(),
            'photos' => $photos,
        ]);
    }

    /**
    * @Route("photo/delete/{id}", name="delete_photo", methods={"POST"})
    */
    public function deletePhoto(Request $request, Photo $photo): Response
    {

        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $request->request->get('_token'))) {
            $filename = $photo->getUserPhoto();
            $fileSystem = new Filesystem();
            $fileSystem->remove('%upload_directory%/public/uploads/'.$filename);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($photo);
            $entityManager->flush();
            $this->addFlash('danger', 'The program is deleted');
        }
        return $this->redirectToRoute('photo');
    }









}
