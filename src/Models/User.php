<?php
namespace Framy\Models;

use Framy\MySQL\Database;
use Framy\Routing\Test;

class User extends Model {
    protected $tableName = "User";

    public function __construct(Database $db){
        parent::__construct($db);
    }
}