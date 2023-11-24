<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    // to pass what u want
    // to make the todo create works!
    // enable mass assigned to all instead of fillable
protected $guarded = [];

}
