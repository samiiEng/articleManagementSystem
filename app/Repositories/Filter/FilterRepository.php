<?php

namespace App\Repositories\Filter;


use App\Exceptions\FilterFormatException;
use App\Models\Department;
use http\Exception;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class FilterRepository
{

    /******** CONVENTION ********
     * $filters ==> @array ==> ['outputTable', 'outputFields' = [*], hasDistinct, [field, operator, value, next], [REPEAT PREVIOUS ARRAY], ....]
     */


    /*
     * This function has no prior filter and just retrieves all departments
     */
    public
    function retrieveDepartments()
    {
//        $departmentsParents = Department::where('department_ref_id', null)->get();
        $departmentsParents = DB::select('SELECT * FROM departments WHERE department_ref_id IS NULL');
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
