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


    /*
     * CONVENTION ==> $filters ==> {"department_id" : [1,2,3,...]}
     */
    public function filterUsernamesByDepartments($filters)
    {
        $departmentsIDs = explode(",", $filters['department_id']);

        //defining the binding
        $length = count($departmentsIDs);
        $binding = [];
        foreach ($departmentsIDs as $departmentID) {
            $binding[] = "$departmentID";
        }

        //defining the conditions
        $conditions = "";
        $i = 0;
        foreach ($departmentsIDs as $departmentsID) {
            ++$i;
            if ($i != $length) {
                $conditions .= "department_id = ? OR ";
            } else {
                $conditions .= "department_id = ?";
            }
        }


        return DB::select("SELECT * FROM users WHERE $conditions", $binding);

    }


    /*
     * CONVENTION ==> $filters ==> {"department_id" : [1,2,3,...]}
     */
    public function filterCategoriesByDepartments($filters)
    {
        $departmentsIDs = explode(',', $filters['department_id']);
        $bindings = [];
        $conditions = "";
        $length = count($departmentsIDs);
        $i = 0;
        foreach ($departmentsIDs as $departmentsID) {
            ++$i;
            if ($i != $length) {
                $conditions .= "department_id = ? OR ";
            } else {
                $conditions .= "department_id = ?";
            }
        }

        $categoriesDepartments = DB::select("SELECT * FROM category_department WHERE $conditions", $bindings);
        $categoriesBasedDepartments = [];
        foreach ($departmentsIDs as $departmentsID) {
            foreach ($categoriesDepartments as $categoriesDepartment) {
                /*
                 * Goal:  getting all records corresponding to a department_id into one index
                 * 1- getting the department info and category info like english name and name as well
                 * and create an associative array out of them.
                 */
                if ($departmentsID == $categoriesDepartment["department_ref_id"]) {
                    $categoryDepartmentID = $categoriesDepartment["category_department_id"];

                    //Getting departments full info
                    $department = DB::select("SELECT * FROM departments WHERE department_id = ?", [$departmentsID]);

                    $departmentID = $department['department_id'];
                    $departmentName = $department['name'];
                    $departmentEnglishName = $department['english_name'];
                    $departmentParentID = $department['department_ref_id'];
                    $departmentParent = DB::select("SELECT * FROM departments WHERE department_id = ?", [$departmentParentID]);
                    $departmentParentName = $departmentParent['name'];
                    $departmentParentEnglishName = $departmentParent['english_name'];


                    //Getting categories full info

                    $category = DB::select("SELECT * FROM categories WHERE category_id = ?", [$categoriesDepartment['category_id']]);
                    $categoryID = $category['category_id'];
                    $categoryName = $category['name'];
                    $categoryEnglishName = $category['english_name'];
                    $categoryParentID = $category['category_ref_id'];

                    $categoryParent = DB::select("SELECT * FROM categories WHERE category_id = ?", [$categoryParentID]);;
                    $categoryParentName = $categoryParent['name'];
                    $categoryParentEnglishName = $categoryParent['english_name'];


                    $categoriesBasedDepartments["$departmentsID"] = array(
                        "categoryDepartmentID" => $categoryDepartmentID,
                        "departmentID" => $departmentID,
                        "departmentName" => $departmentName,
                        "departmentEnglishName" => $departmentEnglishName,
                        "departmentParentID" => $departmentParentID,
                        "departmentParentName" => $departmentParentName,
                        "departmentParentEnglishName" => $departmentParentEnglishName,
                        "categoryID" => $categoryID,
                        "categoryName" => $categoryName,
                        "categoryEnglishName" => $categoryEnglishName,
                        "categoryParentID" => $categoryParentID,
                        "categoryParentName" => $categoryParentName,
                        "categoryParentEnglishName" => $categoryParentEnglishName
                    );
                }
            }
        }

        return $categoriesBasedDepartments;

    }

    public function filterUsernamesByCategoriesDepartments($filters)
    {

    }

    public function filterArticlesByCategoriesDepartments($filters)
    {

    }
}
