<?php

namespace App\Traits;

trait ReadableHumanDate
{
    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
