<?php

namespace App\Controller\Admin;

use App\Entity\AttributeCase;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends CRUDController
{
    public function getAttributeCasesAction($id)
    {
        $attributeCaseRepo = $this->getDoctrine()->getRepository(AttributeCase::class);
        $attributesCases = $attributeCaseRepo->createQueryBuilder('c')
            ->where('c.attribute = :id')
            ->setParameter('id', $id)
            ->orderBy('c.sortOrder')
            ->getQuery()
            ->execute();
        return new JsonResponse($attributesCases);
    }
}