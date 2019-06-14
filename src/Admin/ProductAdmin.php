<?php
namespace App\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\Form\Type\CollectionType;
use Vich\UploaderBundle\Form\Type\VichImageType;
class ProductAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('categories')
            ->addIdentifier('description')
            ->add('price')
            ->add('count')
            ->add('isTop')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('categories')
            ->add('description')
            ->add('price')
            ->add('count')
            ->add('isTop')
        ;
    }
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
            ->add('categories', null, [
                'attr' => [
                    'class' => 'js-product-category',
                ]
            ])
            ->add('description')
            ->add('price')
            ->add('count')
            ->add('isTop')
            ->add('image', VichImageType::class, [
                'required' => false,
            ])
            ->add(
                'attributeValues',
                CollectionType::class,
                [
                    'by_reference' => false
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                ]
            );
        ;
    }
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('getAttributeCases', 'get-attribute-cases/{id}');
    }
}