<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;

class Earning extends Model
{
    use ReadableHumanDate;

    protected $fillable = ['amount', 'date', 'statement', 'school_id'];

}
