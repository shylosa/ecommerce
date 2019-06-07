<?php
namespace App\Admin;
use App\Form\MoneyTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class OrderItemAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('product')
            ->add('count', null, [
                'attr' => ['class' => 'js-item-count js-recalc-cost']
            ])
            ->add('price', NumberType::class, [
                'scale' => 2,
                'attr' => ['class' => 'js-item-price js-recalc-cost']
            ])
            ->add('amount', NumberType::class, [
                'scale' => 2,
                'attr' => ['class' => 'js-item-amount', 'readonly']
            ]);
        $form->get('price')->addModelTransformer(new MoneyTransformer());
        $form->get('amount')->addModelTransformer(new MoneyTransformer());
    }
}