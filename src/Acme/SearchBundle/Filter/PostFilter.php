<?php

namespace Acme\SearchBundle\Filter;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr;



class PostFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
                'title', 
                'filter_text',
                array('apply_filter' => function( QueryBuilder $queryBuilder, Expr $expr, $field, array $values)
                {
                    if (!empty($values['value']))
                    {
                        $queryBuilder->andWhere('p.title LIKE :title')
                            ->setParameter('title', '%'.$values['value'].'%');
                    }
                    
                },
          ));
    }

    public function getName()
    {
        return 'post_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') 
        ));
    }
}