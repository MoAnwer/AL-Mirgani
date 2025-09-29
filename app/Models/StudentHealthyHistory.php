<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentHealthyHistory extends Model
{
    protected $fillable = ['diagnosis', 'medication', 'student_id', 'notes'];


    public function casts(): array
    {
        return [
            'medication' => 'collection'
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
