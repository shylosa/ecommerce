<?php
namespace App\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
class AttributeValueAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('attribute', null, [
                'attr' => [
                    'class' => 'js-product-attribute'
                ]
            ])
            ->add('value', null, [
                'attr' => [
                    'class' => 'js-product-attribute-value'
                ]
            ]);
    }
}