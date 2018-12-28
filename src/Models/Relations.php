<?php

namespace ahmetcelikezer\laravelFlagSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Relations extends Model
{

    private $tableName = require(__DIR__ . 'config.php')['relations_table'];
    protected $table = $this->tableName;
}
