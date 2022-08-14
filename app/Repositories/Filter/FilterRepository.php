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
        //until $i = 3, $outputTable, $outputFields, $hasDistinct must be filled otherwise an exception would be thrown!
        $i = 0;
        $outputTable = null;
        $outputFields = null;
        $hasDistinct = null;

        foreach ($request as $key => $value) {
            if ($key == 'outputTable') {
                $outputTable = $value;
                ++$i;
            }
            if ($key == 'outputFields') {
                $outputFields = $value;
                ++$i;
            }
            if ($key == 'hasDistinct') {
                $hasDistinct = $value;
                ++$i;
            }
            if ($i == 3 && ($hasDistinct == null or $outputFields == null or $outputTable == null)) {
                throw new FilterFormatException();
            }

            /*
            All the previous indexes should have the correct format, must be initiated and we should not have
            repetitive indexes therefor $i == 3;
            */
            $conditions = [];
            $conditionNumber = 0;
            if ($i == 3)
                foreach ($value as $itemKey => $item) {
                    if ($itemKey == 'field'){
                        $field = $item;
                    }
                    if ($itemKey == 'operator'){
                        $operator = $item;
                    }
                    if ($itemKey == 'value'){
                        $value = $item;
                    }
                    if ($itemKey == 'next'){
                        $next = $item;
                    }
                }
            if ($field == null, $operator == null, $value == null, $next == null){
                throw new FilterFormatException();
            }
            ++$conditionNumber;
        }

        DB::select('SELECT ')

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
