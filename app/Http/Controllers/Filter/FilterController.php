<?php

namespace App\Http\Controllers\Filter;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRequest;
use App\Models\Department;
use App\Repositories\Filter\FilterRepository;
use Illuminate\Http\Request;

;

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

    public function filterOneModelMultiConditions(FilterRepository $filterRepository, Request $request)
    {
//        $validated = $filterRequest->validated();
        $result = $filterRepository->filterOneModelMultiConditions($request);
//        $result = $filterRepository->filterOneModelMultiConditions($validated);
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
