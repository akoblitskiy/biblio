<?php
namespace Src\Model;

use Core\Model;

class Publisher extends Model {
    protected static $tableName = 'publisher';
    protected static $primaryKeys = 'id';

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var array */
    private $Books;
}