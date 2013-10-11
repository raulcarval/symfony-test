<?php
namespace Acme\SearchBundle\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface; 	
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\QueryBuilder;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
/**
* 
*/
class PostFilterType extends AbstractType
{	
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title');

	}

	public function getName()
	{
		return 'filter_post';
	}

	public function setDefaultsOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'csrf_protection' => false,
			'validation_groups' => array('filtering')
			));
	}


}
