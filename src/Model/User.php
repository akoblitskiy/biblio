<?php
namespace Src\Model;

use Core\Model;

class Author extends Model {
    protected static $tableName = 'author';
    protected static $primaryKeys = 'id';
    protected static $relations =
        [
            'Book' => [
                'transition' => [ 'model' => 'BookAuthor', 'table' => 'book_to_author'],
                'from' => [ 'local' => 'id', 'foreign' => 'author_id' ],
                'to' => [ 'local' => 'book_id', 'foreign' => 'id' ]
            ],
        ];

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $bio;

    /** @var array */
    private $Books;
}