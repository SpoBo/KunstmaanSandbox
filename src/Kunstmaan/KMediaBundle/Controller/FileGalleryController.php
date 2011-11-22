<?php
// src/Blogger/BlogBundle/Controller/CommentController.php

namespace Kunstmaan\KMediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Kunstmaan\KMediaBundle\Helper\ImageHelper;
use Kunstmaan\KMediaBundle\Form\ImageGalleryType;
use Kunstmaan\KMediaBundle\Entity\ImageGallery;
use Kunstmaan\KMediaBundle\Form\SubFileGalleryType;
use Kunstmaan\KMediaBundle\Form\FileGalleryType;
use Kunstmaan\KMediaBundle\Entity\FileGallery;

/**
 * imagegallery controller.
 *
 * @author Kristof Van Cauwenbergh
 */
class FileGalleryController extends Controller
{

    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $gallery = $em->getRepository('KunstmaanKMediaBundle:FileGallery')->find($id);
        $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                        ->getAllGalleries();

        if (!$gallery) {
            throw $this->createNotFoundException('Unable to find image gallery.');
        }

        return $this->render('KunstmaanKMediaBundle:FileGallery:show.html.twig', array(
            'gallery'       => $gallery,
            'galleries'     => $galleries
         ));
    }

    public function newAction(){
        $gallery = new ImageGallery();
        $form = $this->createForm(new ImageGalleryType(), $gallery);

        $em = $this->getDoctrine()->getEntityManager();
        $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                               ->getAllGalleries();

        return $this->render('KunstmaanKMediaBundle:FileGallery:create.html.twig', array(
            'form'   => $form->createView(),
            'galleries'     => $galleries
        ));
    }

    public function subnewAction($id){
           $gallery = new FileGallery();

           $em = $this->getDoctrine()->getEntityManager();
           $parent = $em->find('\Kunstmaan\KMediaBundle\Entity\FileGallery', $id);

           $gallery->setParent($parent);
           $form = $this->createForm(new SubFileGalleryType(), $gallery);

           $em = $this->getDoctrine()->getEntityManager();
           $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                                  ->getAllGalleries();

           return $this->render('KunstmaanKMediaBundle:FileGallery:subcreate.html.twig', array(
               'form'   => $form->createView(),
               'galleries'     => $galleries,
               'parent' => $parent
           ));
       }

    public function createAction(){
        $request = $this->getRequest();
        $gallery = new FileGallery();
        $form = $this->createForm(new FileGalleryType(), $gallery);

        if ('POST' == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()){
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($gallery);
                $em->flush();

                $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                                               ->getAllGalleries();

                return $this->render('KunstmaanKMediaBundle:FileGallery:show.html.twig', array(
                          'gallery' => $gallery,
                          'galleries' => $galleries,
                ));
            }
        }

        $em = $this->getDoctrine()->getEntityManager();
        $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                                       ->getAllGalleries();

        return $this->render('KunstmaanKMediaBundle:FileGallery:create.html.twig', array(
            'form' => $form->createView(),
            'galleries' => $galleries
        ));
    }

    public function subcreateAction($id){
            $request = $this->getRequest();

            $em = $this->getDoctrine()->getEntityManager();
            $parent = $em->find('\Kunstmaan\KMediaBundle\Entity\FileGallery', $id);

            $gallery = new FileGallery();
            $gallery->setParent($parent);
            $form = $this->createForm(new SubFileGalleryType(), $gallery);

            if ('POST' == $request->getMethod()) {
                $form->bindRequest($request);
                if ($form->isValid()){
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($gallery);
                    $em->flush();

                    $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                                                   ->getAllGalleries();

                    return $this->render('KunstmaanKMediaBundle:FileGallery:show.html.twig', array(
                              'gallery' => $gallery,
                              'galleries' => $galleries,
                    ));
                }
            }

            $em = $this->getDoctrine()->getEntityManager();
            $galleries = $em->getRepository('KunstmaanKMediaBundle:FileGallery')
                                           ->getAllGalleries();

            return $this->render('KunstmaanKMediaBundle:FileGallery:subcreate.html.twig', array(
                'form' => $form->createView(),
                'galleries' => $galleries,
                'parent' => $parent
            ));
        }
}