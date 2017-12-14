<?php

namespace UploadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use UploadBundle\Entity\Gallery;
use UploadBundle\Form\GalleryType;
use UploadBundle\Entity\Photo;


/**
 * Class DefaultController
 * @package UploadBundle\Controller
 * @Route("upload")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, null, [
            'method'=>'POST'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photoFiles = $form->get('photo')->getData();
            foreach ($photoFiles as $photoFile) {
                $photoName = $this->get('upload.file_upload')->upload($photoFile);

                $photo = (new Photo())->setFileName($photoName)->setGallery($gallery);
                $gallery->addPhoto($photo)->setName($form->get('name')->getData());
                $em->persist($photo);
            }

            $em->persist($gallery);

            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('UploadBundle:Default:index.html.twig', ['form'=>$form->createView()]);
    }


    public function editAction(Request $request)
    {

    }

}
