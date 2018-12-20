<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function rows()
    {
        return $this->hasMany(Rows::class, 'ReportId', 'id');
    }
}
