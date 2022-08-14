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

    public function filterOneModelMultiConditions($request)
    {

        //************** GETTING THE DIFFERENT PARTS OF SQL QUERY FROM THE REQUEST ******************

        //until $i = 3, $outputTable, $outputFields, $hasDistinct must be filled otherwise an exception would be thrown!
        $i = 0;
        $arrayIndexesIterated = 0;
        $length = count($request->input());
        $request = $request->input();
        $outputTable = null;
        $outputFields = null;
        $hasDistinct = null;
        $conditions = [];
        $conditionNumber = 0;
        $field = null;

        foreach ($request as $key => $value) {
            if ($key == 'outputTable') {
                $outputTable = $value;
                ++$arrayIndexesIterated;
            }
            if ($key == 'outputFields') {
                $outputFields = $value;
                ++$arrayIndexesIterated;
            }
            if ($key == 'hasDistinct') {
                $hasDistinct = $value;
                ++$arrayIndexesIterated;
            }

            /*
            All the previous indexes should have the correct format, must be initiated and we should not have
            repetitive indexes therefor $i == 3;
            */
            ++$i;
            if ($i == 1 && $outputTable == null) {
                throw new FilterFormatException("outputTable index is either empty or the index is misspelled");
            }
            if ($i == 2 && $outputFields == null) {
                throw new FilterFormatException("outputFields index is either empty or the index is misspelled");
            }

            /*
             * checking that if any overwrite has happened by having two outputTable or outputField keys then make sure that those
             * values did not become null
            */
            if ($i == 3 && ($outputTable == null or $outputFields == null)) {
                throw new FilterFormatException("outputTable or outputFields index are either empty or the indexes are misspelled");
            }


            /*
            All the previous indexes should have the correct format, must be initiated and we should not have
            repetitive indexes therefor $i == 3;
            otherwise we can get the conditions part of the request input[field, operator, value, next].
            */

            if ($i == 3) {
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

                if ($field == null or $operator == null) {
                    throw new FilterFormatException("Either your field or your operator index is misspelled or undefined");
                }

                if (($operator == 'IS NULL' or $operator == 'IS NOT NULL') && $value != null) {
                    throw new FilterFormatException();
                }

                //if we still have conditions then next cannot be null!
                ++$arrayIndexesIterated;
                if ($arrayIndexesIterated != $length && $next != null)
                    throw new FilterFormatException();

                $conditions[$conditionNumber] = [$field, $operator, $value, $next];
                ++$conditionNumber;
            }
        }
        //-------------- END OF  GETTING THE DIFFERENT PARTS OF SQL QUERY FROM THE REQUEST -----------------

        $query = "SELECT " . $hasDistinct . " " . $outputFields . " FROM " . $outputTable . " WHERE";
        $valuesNumbers = 0;
        $values = [];
        foreach ($conditions as $condition) {
            $query += " " . $condition[0] . " " . $condition[1] . " ? " . $condition[3];
            $values[$valuesNumbers] = $condition[2];
            ++$valuesNumbers;
        }

        $binding = [];
        foreach ($values as $valueItem) {
            $valueItem = !empty($valueItem) ? $valueItem : " ";
            $binding[] = $valueItem;
        }

        return DB::select($query, $binding);

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
