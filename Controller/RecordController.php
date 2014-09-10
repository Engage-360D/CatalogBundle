<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Controller;

use Engage360d\Bundle\CatalogBundle\Entity\Record;
use Engage360d\Bundle\CatalogBundle\Form\Type\RecordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordController extends Controller
{
    public function addAction(Request $request)
    {
        $record = new Record();
        $form = $this->createForm(new RecordFormType(), $record);

        $form->handleRequest($request);

        if ($form->isValid()) {
//            if (!$record->getOrder()) {
//                $record->setOrder(count($record->getCatalog()->getRecords()));
//            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            return new Response('The record was added.');
        }

        return $this->render('Engage360dCatalogBundle:Record:add.html.twig',
            array('form' => $form->createView())
        );
    }
}