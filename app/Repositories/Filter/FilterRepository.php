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


    public function filterUsernamesByDepartments($filters)
    {
        /*
         * CONVENTION ==> $filters ==> {"department_id" : [1,2,3,...]}
         */

        $departmentIDs = [];
        foreach ($filters as $key => $value) {
            //double-checking on the retrieved filters to only check the value we want
            if ($key == "department_id") {
                $departmentIDs = explode(",", $value);
            }
        }

        //defining the binding
        $count = count($departmentIDs);
        $binding = [];
        foreach ($departmentIDs as $departmentID) {
            $binding[] = "$departmentID";
        }

        //defining the conditions
        $conditions = "";

        for ($i = 1; $i <= $count; $i++) {
            if ($i != $count)
                $conditions .= "department_ref_id = ? OR ";
            else
                $conditions .= "department_ref_id = ?";
        }


        return DB::select("SELECT * FROM users WHERE $conditions", $binding);

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
