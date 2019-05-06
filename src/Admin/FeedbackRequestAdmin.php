<?php

namespace App\Admin;

use App\Entity\FeedbackRequest;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class FeedbackRequestAdmin extends AbstractAdmin
{

	protected function configureListFields(ListMapper $list)
	{
		$list
            ->add('name')
            ->addIdentifier('email')
            ->add('topic')
            ->add('message')
		;
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter
			->add('name')
			->add('email')
			->add('topic')
			->add('message')
		;
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form
            ->add('name', null, [
                'label' => 'Имя'
            ])
            ->add('email', EmailType::class)
            ->add('topic', ChoiceType::class, [
                'choices' => array_flip(FeedbackRequest::$topics),
                'placeholder' => 'Выберите тему',
                    'label' => 'Тема'
            ])
            ->add('message', null, [
                'label' => 'Сообщение'
            ])
        ;

		;
	}

}
