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
    function retrievingDepartments($filters)
    {
        $filterRepository = new FilterRepository();
        $departments = $filterRepository->retrievingDepartments();
        return response()->view("{{$filters[0]}}", ['departments' => $departments]);
    }

    /*
     *
     */
    public function retrievingDepartmentBasedCategories(FilterRepository $filterRepository, $filters)
    {
       /* $categories = $filterRepository->retrievingDepartmentBasedCategories($filters);
        return response()->view("$filters[0]", ["categories" => "$categories"]);*/
    }

    public function retrievingUsernamesByDepartments(FilterRepository $filterRepository, $filters)
    {



    }

    public function retrievingArticlesByDepartmentsCategories(FilterRepository $filterRepository, $filters)
    {

    }
}
