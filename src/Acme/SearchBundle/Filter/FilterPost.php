<?php

namespace Acme\SearchBundle\Filter;

use IDCI\Bundle\FilterFormBundle\Form\Filter\TextFieldEntityAbstractFilter;

class FilterPost extends TextFieldEntityAbstractFilter
{
    public function getEntityClassName() { return "AcmeSearchBundle:Post"; }

    public function getEntityFieldName() { return "title"; }

    public function getFilterFormLabel() { return "Title"; }

    public function getFilterName() { return "title"; }
}