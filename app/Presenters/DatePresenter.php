<?php

namespace App\Presenters;

trait DatePresenter
{
  public function getCreatedAtAttribute($value)
  {
    return \Carbon\Carbon::parse($value)->format('m/d/Y H:i');
  }
}