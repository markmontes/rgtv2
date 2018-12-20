<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rows extends Model
{
    public function cells()
    {
        return $this->hasMany(Cells::class, 'rowId', 'id');
    }
}
