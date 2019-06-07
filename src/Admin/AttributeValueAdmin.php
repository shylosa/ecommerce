<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AttributeValueAdmin extends AbstractAdmin
{

	protected function configureListFields(ListMapper $list)
	{
		$list
			->addIdentifier('attribute')
			->add('value')
		;
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter
			->add('attribute')
			->add('value')
		;
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form
			->add('attribute')
			->add('value')
		;
	}

}
