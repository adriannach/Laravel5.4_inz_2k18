<?php

namespace App\Presenters;

trait DataP
{
  public function getCreatedAtAttribute($data)
  {
    return \Carbon\Carbon::parse($data)->format('d-m-Y  G:i');
  }

  public function getUpdatedAtAttribute($data)
  {
    return \Carbon\Carbon::parse($data)->format('d-m-Y  G:i');
  }
}
