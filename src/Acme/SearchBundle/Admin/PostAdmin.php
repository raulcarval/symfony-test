<?php
// src/Acme/DemoBundle/Admin/PostAdmin.php

namespace Acme\SearchBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PostAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('title', 'text', array('label' => 'Título'))
            ->add('content', 'textarea', array('label' => 'Conteúdo'))
            ->add('comment', 'entity', array('label' => 'Comentários', 'class' => 'Acme\SearchBundle\Entity\Comment'))
            #->add('author', 'entity', array('class' => 'Acme\SearchBundle\Entity\Post'))
            #->add('body') //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('content')
            ->add('comment')
            #->add('author')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title', 'text',array('label' => 'Título'))
            ->add('comment')
            #->add('slug')
            #->add('author')
        ;
    }
}