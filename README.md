# Biblio library
## REST JSON API project

## Installation

Install nginx version 1.4 + php-fpm version 7.2
DB server - install mysql 5.7
Dont forget about mysql driver for php (php-mysql package)

nginx and mysql configs are in files ngingx-config and mysqld.cnf in project root directory

Database dump - db.sql

###Usage

3 route types for entities with the same name -
`book` `author` `publisher`

Examples

GET method:
`book/1` - get book by id = 1
`book?_page=1` - get books on page 1
`book?name=Book` - get books with name 'Book' - pass any entity fields as query args
POST method:
`book` url with post body
`{ id: 1, name: "Name" ... }`
returns 204 No Content if successful

PUT and DELETE methods:
`book/{id}` url
for put is also needed modified object in request body

returns 204 No Content if successful
