<?php 
namespace Acme\SearchBundle\Filter;

use IDCI\Bundle\FilterFormBundle\Form\FilterManager\EntityAbstractFilterManager;

class FilterManager extends EntityAbstractFilterManager
{
    public function buildFilters($options = array())
    {
        // We have to add the previous filters
        $this
            ->addFilter(new FilterPost());
        ;
    }

    public function getEntityClassName()
    {
        return "Acme\SearchBundle\Entity\Post";
    }
}