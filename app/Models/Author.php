<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public function academic_work()
    {
        return $this->belongsTo("App\AcademicWork", "academic_works_id");
    }
}
