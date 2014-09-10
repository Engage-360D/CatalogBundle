<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Engage360d\Bundle\CatalogBundle\Entity\Catalog;
use Engage360d\Bundle\CatalogBundle\Form\Type\CatalogFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CatalogController extends Controller
{
    public function addAction(Request $request)
    {
        $catalog = new Catalog();
        $form = $this->createForm(new CatalogFormType(), $catalog);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($catalog);
            $entityManager->flush();

            return new Response('The catalog was added.');
        }

        return $this->render('Engage360dCatalogBundle:Catalog:add.html.twig',
            array('form' => $form->createView())
        );
    }
}