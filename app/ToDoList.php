<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoList extends Model
{
	protected $table = 'to_do_list_dtl';
    public $fillable = ['id'];
}
