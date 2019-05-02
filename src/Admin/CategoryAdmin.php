<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{

	protected function configureListFields(ListMapper $list)
	{
		$list
			->addIdentifier('name')
		;
	}

	protected function configureDatagridFilters(DatagridMapper $filter)
	{
		$filter
			->add('name')
		;
	}

	protected function configureFormFields(FormMapper $form)
	{
		$form
			->add('name')
		;
	}

}
