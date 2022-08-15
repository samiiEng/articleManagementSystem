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
            $departmentsChildren = DB::select('SELECT * FROM departments WHERE department_ref_id = ' . $parentID);
            $i++;
            $departments[$i] = [$departmentsParent, $departmentsChildren];
        }
        return $departments;

    }


    /*
     * CONVENTION ==> $filters ==> {"department_id" : [1,2,3,...]}
     * @return ==>
     */
    public function filterUsernamesByDepartments($filters)
    {
        $departmentsIDs = explode(",", $filters['department_id']);

        //defining the binding
        $length = count($departmentsIDs);
        $binding = [];

        //defining the conditions and bindings
        $conditions = "";
        $i = 0;
        foreach ($departmentsIDs as $departmentsID) {
            ++$i;
            if ($i != $length) {
                $conditions .= "department_ref_id = ? OR ";
                $j = $i - 1;
                $binding[] = $departmentsIDs[$j];
            } else {
                $conditions .= "department_ref_id = ?";
                $j = $i - 1;
                $binding[] = $departmentsIDs[$j];
            }
        }


        $usernames = DB::select("SELECT * FROM users WHERE $conditions", $binding);

        foreach ($departmentsIDs as $departmentsID) {
            $flag = true;
            foreach ($usernames as $usernameValue) {
                if ($departmentsID == $usernameValue->department_ref_id) {
                    //Get departments' information just once
                    if ($flag) {
                        $department = DB::select('SELECT * FROM departments WHERE department_id = ?', [$departmentsID]);
                        $departmentID = $department[0]->department_id;
                        $departmentName = $department[0]->name;
                        $departmentEnglishName = $department[0]->english_name;
                        $departmentParentID = $department[0]->department_ref_id;
                        if (!empty($departmentParentID)) {
                            $departmentParent = DB::select('SELECT * FROM departments WHERE department_id = ?', [$departmentParentID]);
                            $departmentParentName = $departmentParent[0]->name;
                            $departmentParentEnglishName = $departmentParent[0]->english_name;
                        }

                        $usernamesByDepartments[$departmentsID][] = array(
                            "departmentID" => $departmentID,
                            "departmentName" => $departmentName,
                            "departmentEnglishName" => $departmentEnglishName,
                            "departmentParentID" => $departmentParentID,
                            "departmentParentName" => $departmentParentName ?? null,
                            "departmentParentEnglishName" => $departmentParentEnglishName ?? null
                        );
                    }

                    //Get users' information
                    $username = $usernameValue->username;
                    $avatarImagePath = $usernameValue->avatar_image_path;
                    $firstName = $usernameValue->first_name;
                    $lastName = $usernameValue->last_name;
                    $usernamesByDepartments[$departmentsID][] = array(
                        "username" => $username,
                        "avatarImagePath" => $avatarImagePath,
                        "firstName" => $firstName,
                        "lastName" => $lastName
                    );
                }
            }
        }
        return $usernamesByDepartments;

    }


    /*
     * CONVENTION ==> $filters ==> {"department_id" : [1,2,3,...]}
     * @returns ==>
     * {
     *  "departmet_ref_id" => [
     *          {department info},
     *          {category info},
     *              .
     *              .
     *              .
     *       ]
     *  }
     */
    public function filterCategoriesByDepartments($filters)
    {
        $departmentsIDs = explode(',', $filters['department_id']);

        //Make conditions and bindings
        $bindings = [];
        $conditions = "";
        $length = count($departmentsIDs);
        $i = 0;
        foreach ($departmentsIDs as $departmentsID) {
            ++$i;
            if ($i != $length) {
                $conditions .= "department_ref_id = ? OR ";
                $j = $i - 1;
                $bindings[] = $departmentsIDs[$j];
            } else {
                $conditions .= "department_ref_id = ?";
                $j = $i - 1;
                $bindings[] = $departmentsIDs[$j];
            }
        }

        $categoriesDepartments = DB::select("SELECT * FROM category_department WHERE $conditions", $bindings);
        $categoriesBasedDepartments = [];
        foreach ($departmentsIDs as $departmentsID) {
            $flag = true;
            foreach ($categoriesDepartments as $categoriesDepartment) {
                /*
                 * Goal:  getting all records corresponding to a department_id into one index
                 * 1- getting the department info and category info like english name and name as well
                 * and create an associative array out of them.
                 */
                if ($departmentsID == $categoriesDepartment->department_ref_id) {
                    $categoryDepartmentID = $categoriesDepartment->category_department_id;

                    //Getting departments full info but just once
                    if ($flag) {
                        $flag = false;
                        $department = DB::select("SELECT * FROM departments WHERE department_id = ?", [$departmentsID]);

                        $departmentID = $department[0]->department_id;
                        $departmentName = $department[0]->name;
                        $departmentEnglishName = $department[0]->english_name;
                        $departmentParentID = $department[0]->department_ref_id;
                        if (!empty($departmentParent)) {
                            $departmentParent = DB::select("SELECT * FROM departments WHERE department_id = ?", [$departmentParentID]);
                            $departmentParentName = $departmentParent[0]->name;
                            $departmentParentEnglishName = $departmentParent[0]->english_name;
                        }

                        $categoriesBasedDepartments["$departmentsID"][] = array(
                            "departmentID" => $departmentID,
                            "departmentName" => $departmentName,
                            "departmentEnglishName" => $departmentEnglishName,
                            "departmentParentID" => $departmentParentID ?? null,
                            "departmentParentName" => $departmentParentName ?? null,
                            "departmentParentEnglishName" => $departmentParentEnglishName ?? null,
                        );
                    }

                    //Getting categories full info

                    $category = DB::select("SELECT * FROM categories WHERE category_id = ?", [$categoriesDepartment->category_ref_id]);
                    $categoryID = $category[0]->category_id;
                    $categoryName = $category[0]->name;
                    $categoryEnglishName = $category[0]->english_name;
                    $categoryParentID = $category[0]->category_ref_id;

                    if (!empty($categoryParentID)) {
                        $categoryParent = DB::select("SELECT * FROM categories WHERE category_id = ?", [$categoryParentID]);;
                        $categoryParentName = $categoryParent[0]->name;
                        $categoryParentEnglishName = $categoryParent[0]->english_name;
                    }


                    $categoriesBasedDepartments["$departmentsID"][] = array(
                        "categoryDepartmentID" => $categoryDepartmentID,
                        "categoryID" => $categoryID,
                        "categoryName" => $categoryName,
                        "categoryEnglishName" => $categoryEnglishName,
                        "categoryParentID" => $categoryParentID ?? null,
                        "categoryParentName" => $categoryParentName ?? null,
                        "categoryParentEnglishName" => $categoryParentEnglishName ?? null
                    );
                }
            }
        }

        return $categoriesBasedDepartments;

    }


    public function filterUsernamesByCategoriesDepartments($filters)
    {


    }

    /*
     * CONVENTION ==> $filters ==> {"category_department_id" : [1,2,3,...]}
     */
    public function filterArticlesByCategoriesDepartments($filters)
    {


    }
}
