<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Repositories\Filter\FilterRepository;

class FilterController extends Controller
{

    /******** CONVENTION *********
     * $filters ==> @array ==> ['view page', ['filter table/model', 'filter value'], ...]
     */

    /*
     * This function has no prior filter and just retrieves all departments
     */
    public
    function retrieveDepartments()
    {
        $filterRepository = new FilterRepository();
        $departments = $filterRepository->retrieveDepartments();
        return $departments;
    }

    public function filterOneModelMultiConditions()
    {


    }

    public function filterUsernamesByDepartments()
    {

    }

    public function filterCategoriesByDepartments($filters)
    {

    }

    public function filterUsernamesByCategoriesDepartments($filters)
    {

    }

    public function filterArticlesByCategoriesDepartments($filters)
    {

    }
}
