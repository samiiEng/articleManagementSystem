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
        $continue = true;

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


            /*
             * checking that if any overwrite has happened by having two outputTable or outputField keys then make sure that those
             * values did not become null
            */
            if ($i == 3) {
                if ($outputTable == null or $outputFields == null)
                    throw new FilterFormatException("outputTable or outputFields index are either empty or the indexes are misspelled");
            }
            if ($i == 3 && ($outputTable != null and $outputFields != null) && $i != $length) {
                if ($continue) {
                    $continue = false;
                    continue;
                }
                /*
                All the previous indexes should have the correct format, must be initiated and we should not have
                repetitive indexes therefor $i == 3;
                otherwise we can get the conditions part of the request input[field, operator, value, next].
                */

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

        /*
         *This operates when we have no conditions and checks If the request's first two indexes are null
         *this is because checking if those indexes are null only happens when $i == 3.
        */
        if ($i < 3)
            if ($outputTable == null or $outputFields == null)
                throw new FilterFormatException("You must have outputTable, outputFields and hasDistinct in your request and first two must not be empty!");

        //========== NOTICE : $i == 3 means there are no conditions!!!!

        //-------------- END OF  GETTING THE DIFFERENT PARTS OF SQL QUERY FROM THE REQUEST -----------------

        $query = "SELECT " . $hasDistinct . " " . $outputFields . " FROM " . $outputTable;

        //this makes this method to handle queries without conditions
        $binding = [];
        if (count($conditions)) {
            $query .= " WHERE";
            $valuesNumbers = 0;
            $values = [];
            foreach ($conditions as $condition) {
                $questionMark = !empty($condition[2]) ? '?' : "";
                $query .= " " . $condition[0] . " " . $condition[1] . " " . $questionMark . " " . $condition[3];

                //only get the non-null values into the binding because the IS NULL/IS NOT NULL is always the last condition
                if (!empty($condition[2])) {
                    $values[$valuesNumbers] = $condition[2];
                    ++$valuesNumbers;
                }
            }


            foreach ($values as $valueItem) {
                $valueItem = !empty($valueItem) ? $valueItem : " ";
                $binding[] = $valueItem;
            }
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
