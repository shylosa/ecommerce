<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 31.05.19
 * Time: 19:18
 */

namespace App\Admin;


use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class OrderAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
        ->addIdentifier('id')
        ->add('user')
        ->addIdentifier('createdAt')
        ->addIdentifier('status')
        ->addIdentifier('isPaid')
        ->add('amount')
        ->add('phone')
        ->add('email');

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('user')
            ->add('createdAt')
            ->add('status')
            ->add('isPaid')
            ->add('amount')
            ->add('phone')
            ->add('email');

    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('id')
            ->add('user')
            ->add('createdAt')
            ->add('status')
            ->add('isPaid')
            ->add('amount', NumberType::class, ['scale'=>2,])
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('orderItems',
                CollectionType::class,
                [
                    'by_reference'=>false
                ],
                [
                    'edit'=>'inline',
                    'inline'=>'table',
                ]
        );

    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('recalc', $this->getRouterIdParameter() . '/recalc');
    }
}