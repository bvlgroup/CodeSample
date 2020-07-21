<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeMain extends Model{
    protected $table = 'code_main';
    protected $fillable = ['in_use', 'cd_group', 'cd_main', 'cd_main_name', 'admin_id_create', 'admin_id_update'];
}
