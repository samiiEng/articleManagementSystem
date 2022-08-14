<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $primaryKey = 'tag_id';

    public function departmentsCategories(){
        return $this->belongsTo(CategoryDepartment::class, 'department_category_ref_id', 'department_category_id');
    }
}
