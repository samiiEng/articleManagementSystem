<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryDepartment extends Pivot
{
    protected $table = 'departments_categories';
    protected $primaryKey = 'department_category_id';

    public function tags(){
        return $this->hasMany(Tag::class, 'department_category_ref_id', 'department_category_id');
    }
}
