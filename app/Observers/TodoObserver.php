<?php

namespace App\Observers;

use App\Models\Todo;

class TodoObserver
{
    public function creating(Todo $todo)
    {
       
        $todo->user_id = auth()->user()->id;
        $todo->save();
    }
}
