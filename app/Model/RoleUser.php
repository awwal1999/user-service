<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{

    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
