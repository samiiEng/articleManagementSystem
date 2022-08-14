<?php

namespace App\Repositories\Filter;


use App\Models\Department;
use Illuminate\Support\Facades\DB;

class FilterRepository
{

    /******** CONVENTION ********
     * $filters ==> @array ==> [['filter table/model', 'filter value'], ...]
     */


    /*
     * This function has no prior filter and just retrieves all departments
     */
    public
    function retrievingDepartments()
    {
//        $departmentsParents = Department::where('department_ref_id', null)->get();
        $departmentsParents = DB::select('SELECT * FROM departments WHERE department_ref_id = null');
        $departments = [];
        $i = 0;
        foreach ($departmentsParents as $departmentsParent) {
            $parentID = $departmentsParent->department_id;
//            $departmentsChildren = Department::where('department_ref_id', $parentID);
            $departmentsChildren = DB::select('SELECT * FROM departments WHERE department_ref_id = ' . $parentID);
            $i++;
            $departments[$i] = [$departmentsParent, $departmentsChildren];
        }
        return $departments;

    }

    /*
     *
     */
    public function retrievingDepartmentBasedCategories($filters)
    {

    }

    public function retrievingUsernamesByDepartments($filters)
    {

    }

    public function retrievingArticlesByDepartmentsCategories($filters)
    {

    }
}
