<?php
namespace Src\Model;

use Core\Model;

class User extends Model {
    protected static $tableName = 'user';
    protected static $primaryKeys = ['id'];
    protected static $relations = null;

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $fullname;

    /** @var string */
    protected $password;

    /** @var \DateTime */
    protected $createdAt;
}