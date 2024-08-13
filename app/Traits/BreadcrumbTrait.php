<?php

namespace App\Traits;

trait BreadcrumbTrait
{
    public function getPagebreadcrumbs($title, $section, $page)
    {
        $data = [];

        $data['title'] = $title;
        $data['section'] = $section;
        $data['page'] = $page;

        return $data;
    }
}
