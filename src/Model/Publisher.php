<?php
namespace Src\Model;

use Core\Model;

/**
 * Class Publisher
 * @package Src\Model
 * @var int $id
 * @var string $name
 */
class Publisher extends Model {
    protected static $tableName = 'publisher';
    protected static $primaryKeys = ['id'];
    protected static $relations =
        [
            'Book' => [
                'has' => 'many',
                'namespace' => 'Src\\Model\\',
                'local' => 'id',
                'foreign' => 'publisher_id'
            ],
        ];

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var array */
    protected $Book;

    public function toJson($with_rel = true) {
        $arr = [ 'id' => $this->id, 'name' => $this->name, 'bio' => $this->bio ];
        return $arr;
    }
}