<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\Department;
use App\Repositories\Filter\FilterRepository;

class FilterController extends Controller
{

    /******** CONVENTION *********
     * $filters ==> @array ==> ['output model/table', 'output fields' = [*], hasDistinct, [field1, operator, value, next(AND, OR, NULL)], [REPEAT PREVIOUS ARRAY], ....]
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

    public function filterOneModelMultiConditions(FilterRepository $filterRepository, FilterRequest $filterRequest)
    {
        $validated = $filterRequest->validated();
        $result = $filterRepository->filterOneModelMultiConditions($validated);
        return response()->json(["status" => "succed", "message" => "", "data" =>$result], 200, ['Content-Type' => 'application/json;charset=UTF-8'], JSON_UNESCAPED_UNICODE);

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
