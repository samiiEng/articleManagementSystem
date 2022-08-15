<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\Department;
use App\Repositories\Filter\FilterRepository;
use Illuminate\Http\Request;



class FilterController extends Controller
{

    /******** CONVENTION *********
     * $filters ==> @array ==> ['outputTable', 'outputFields' = [*], hasDistinct, [field, operator, value, next], [REPEAT PREVIOUS ARRAY], ....]
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


    public function filterUsernamesByDepartments(FilterRequest $filterRequest, FilterRepository $filterRepository)
    {
        $validated = $filterRequest->safe()->only('department_id');
        $results = $filterRepository->filterUsernamesByDepartments($validated);
        $results = structuredJson($results);
        return response()->json($results[0], $results[1], $results[2], $results[3]);
    }

    public function filterCategoriesByDepartments(FilterRequest $filterRequest, FilterRepository $filterRepository)
    {


    }

    public function filterUsernamesByCategoriesDepartments($filters)
    {

    }

    public function filterArticlesByCategoriesDepartments($filters)
    {

    }
}
