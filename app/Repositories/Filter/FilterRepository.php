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
     * $filters ==> @array ==> ['output model/table', 'output fields' = [*], hasDistinct, [field1, operator, value, next(AND, OR, NULL)], [REPEAT PREVIOUS ARRAY], ....]
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

    public function filterOneModelMultiConditions($request)
    {

        //************** GETTING THE DIFFERENT PARTS OF SQL QUERY FROM THE REQUEST ******************

        //until $i = 3, $outputTable, $outputFields, $hasDistinct must be filled otherwise an exception would be thrown!
        $i = 0;
        $arrayIndexesIterated = 0;
        $length = sizeof($request);
        $outputTable = null;
        $outputFields = null;
        $hasDistinct = null;
        $conditions = [];
        $conditionNumber = 0;

        foreach ($request as $key => $value) {
            if ($key == 'outputTable') {
                $outputTable = $value;
                ++$i;
                ++$arrayIndexesIterated;
            }
            if ($key == 'outputFields') {
                $outputFields = $value;
                ++$i;
                ++$arrayIndexesIterated;
            }
            if ($key == 'hasDistinct') {
                $hasDistinct = $value;
                ++$i;
                ++$arrayIndexesIterated;
            }
            if ($i == 3 && ($hasDistinct == null OR $outputFields == null OR $outputTable == null)) {
                throw new FilterFormatException();
            }

            /*
            All the previous indexes should have the correct format, must be initiated and we should not have
            repetitive indexes therefor $i == 3;
            */

            if ($i == 3)
                foreach ($value as $itemKey => $item) {
                    if ($itemKey == 'field') {
                        $field = $item;
                    }
                    if ($itemKey == 'operator') {
                        $operator = $item;
                    }
                    if ($itemKey == 'value') {
                        $value = $item;
                    }
                    if ($itemKey == 'next') {
                        $next = $item;
                    }
                }

            if ($field == null OR $operator == null) {
                throw new FilterFormatException();
            }

            if (($operator == 'IS NULL' OR $operator == 'IS NOT NULL') && $value != null) {
                throw new FilterFormatException();
            }

            //if we still have conditions then next cannot be null!
            ++$arrayIndexesIterated;
            if ($arrayIndexesIterated != $length && $next != null)
                throw new FilterFormatException();

            $conditions[$conditionNumber] = [$field, $operator, $value, $next];
            ++$conditionNumber;
        }
        //-------------- END OF  GETTING THE DIFFERENT PARTS OF SQL QUERY FROM THE REQUEST -----------------

        $query = "SELECT $outputFields FROM $outputTable WHERE";
        foreach ($conditions as $condition) {
            $query += " ". $condition[0] . " " . $condition[1] . " " . $condition[2]  . " " . $condition[3];
        }

        $result = DB::select($query);
        return $result;

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
