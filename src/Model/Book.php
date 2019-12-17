<?php
namespace Src\Model;

use Core\DBManager;
use Core\Model;

/**
 * Class Book
 * @package Src\Model
 * @var int $id
 * @var string $name
 * @var string $description
 * @var string $year
 * @var int $pagesCount
 * @var int $publisherId
 */
class Book extends Model {
    protected static $tableName = 'book';
    protected static $primaryKeys = ['id'];
    protected static $relations =
    [
        'Author' => [
            'has' => 'many',
            'namespace' => 'Src\\Model\\',
            'transition' => [ 'model' => 'BookAuthor', 'table' => 'book_to_author'],
            'from' => [ 'local' => 'id', 'foreign' => 'book_id' ],
            'to' => [ 'local' => 'author_id', 'foreign' => 'id' ]
        ],
        'Publisher' => [
            'has' => 'one',
            'namespace' => 'Src\\Model\\',
            'local' => 'publisher_id',
            'foreign' => 'id'
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
    protected $description;

    /** @var string */
    protected $year;

    /** @var int */
    protected $pagesCount;

    /** @var int */
    protected $publisherId;

    /** @var array */
    protected $Author;

    /** @var Publisher */
    protected $Publisher;

    public function toJson($with_rel = true) {
        $arr = [ 'id' => $this->id, 'name' => $this->name, 'description' => $this->description, 'year' => $this->year, 'pagesCount' => $this->pagesCount ];
        if ($with_rel) {
            $authors = [];
            foreach ($this->Author as $author) {
                $authors[] = $author->toJson(false);
            }
            $arr['Author'] = $authors;
            $arr['Publisher'] = $this->Publisher->toJson(false);
        }
        return $arr;
    }

    public function saveAuthorRelation($book, $author) {
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
        if ($this->Author) {
            foreach ($this->Author as $author) {
                if (!Author::findBy('id', $author->getId())) {
                    $author->insert();
                    $this->saveAuthorRelation($this, $author);
                } else {
                    $author->update();
                }
            }
        }
        if ($this->Publisher) {
            $this->Publisher->insert();
        }
    }
}