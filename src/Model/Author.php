<?php
namespace Src\Model;

use Core\DBManager;
use Core\Model;

/**
 * Class Author
 * @package Src\Model
 * @var int $id
 * @var string $name
 * @var string $bio
 */
class Author extends Model {
    protected static $tableName = 'author';
    protected static $primaryKeys = ['id'];
    protected static $relations =
        [
            'Book' => [
                'has' => 'many',
                'namespace' => 'Src\\Model\\',
                'transition' => [ 'model' => 'BookAuthor', 'table' => 'book_to_author'],
                'from' => [ 'local' => 'id', 'foreign' => 'author_id' ],
                'to' => [ 'local' => 'book_id', 'foreign' => 'id' ]
            ],
        ];

    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /** @var string */
    protected $name;

    /** @var string */
    protected $bio;

    /** @var array */
    protected $Book;

    public function toJson($with_rel = true) {
        $arr = [ 'id' => $this->id, 'name' => $this->name, 'bio' => $this->bio ];
        if ($with_rel) {
            $books = [];
            foreach ($this->Book as $book) {
                $books[] = $book->toJson(false);
            }
            $arr['Book'] = $books;
        }
        return $arr;
    }

    public function saveBookRelation($author, $book) {
        $conn = DBManager::getConnection();
        $sql = "INSERT INTO book_to_author";
        $insertParams = [$book->getId(), $author->getId()];
        $sql .= " (`book_id`,`author_id`) VALUES (?,?)";

        $stmt = $conn->prepare($sql);

        foreach ($insertParams as $key => $value) {
            $stmt->bindParam($key + 1, $value);
        }

        $result = $stmt->execute();
        if ($result === false) {
            return [ 'error' => 'Error handling SQL query' ];
        }

        return $result;
    }

    public function insertRelations() {
        if ($this->Book) {
            foreach ($this->Book as $book) {
                if (!Author::findBy('id', $book->getId())) {
                    $book->insert();
                    $this->saveBookRelation($this, $book);
                } else {
                    $book->update();
                }
            }
        }
        if ($this->Publisher) {
            $this->Publisher->insert();
        }
    }
}