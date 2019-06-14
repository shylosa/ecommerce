<?php
namespace App\Admin;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Repository\AttributeRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class AttributeValueAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        /** @var AttributeValue $attributeValue */
        $attributeValue = $this->getSubject();
        $form
            ->add('attribute', null, [
                'class' => Attribute::class,
                'query_builder' => function (AttributeRepository $repository) use ($attributeValue) {
                    $categoriesIds = [];
                    foreach ($attributeValue->getProduct()->getCategories() as $category) {
                        $categoriesIds[] = $category->getId();
                    }
                    $qb = $repository->createQueryBuilder('a');
                    $qb
                        ->join('a.categories', 'c')
                        ->where($qb->expr()->in('c.id', $categoriesIds));
                    return $qb;
                },
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