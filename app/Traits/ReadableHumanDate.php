<?php

namespace App\Traits;

trait ReadableHumanDate
{
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getFormattedDateAttribute() 
    {
        return $this->date->diffForHumans();
    }
}
