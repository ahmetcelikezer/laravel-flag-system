<?php

namespace ahmetcelikezer\laravelFlagSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Flags extends Model
{
    private $tableName = require(__DIR__ . 'config.php')['flags_table'];
    protected $table = $this->tableName;
}
