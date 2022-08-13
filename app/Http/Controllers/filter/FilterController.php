<?php

namespace App\Http\Controllers\filter;

use App\Http\Controllers\Controller;
use App\Models\Department;

class FilterController extends Controller
{
    public function sendingFilterOptionsToView($whichFilterType, $model, $conditions){
        $departmentsParents = Department::where('department_ref_id', null)->get();
        $departments = [];
        $i = 0;
        foreach($departmentsParents as $departmentsParent){
            $parentID = $departmentsParent->department_id;
            $departmentsChildren = Department::where('department_ref_id', $parentID);
            $i++;
            $departments[$i] = [$departmentsParent, $departmentsChildren];
        }

        return response()->view('defineArticle', ['departments' => $departments]);
    }
}
