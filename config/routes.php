<?php
return [
    'index' =>
        [
            'path' => '/',
            'method' => 'GET',
            'controller' => 'MainController',
            'action' => 'index'
        ],
    'login' =>
        [
            'path' => '/login',
            'method' => 'POST',
            'controller' => 'UserController',
            'action' => 'login'
        ],
    'signup' =>
        [
            'path' => '/signup',
            'method' => 'POST',
            'controller' => 'UserController',
            'action' => 'signup'
        ],
    'books' =>
        [
            'path' => '/book/:id',
            'method' => 'GET',
            'controller' => 'BookController',
            'action' => 'show',
        ],
    'createBook' =>
        [
            'path' => '/book',
            'method' => 'POST',
            'controller' => 'BookController',
            'action' => 'create',
        ],
    'updateBook' =>
        [
            'path' => '/book/:id',
            'method' => 'PUT',
            'controller' => 'BookController',
            'action' => 'update',
        ],
    'deleteBook' =>
        [
            'path' => '/book/:id',
            'method' => 'DELETE',
            'controller' => 'BookController',
            'action' => 'delete',
        ],
    'authors' =>
        [
            'path' => '/author/:id',
            'method' => 'GET',
            'controller' => 'BookController',
            'action' => 'show',
        ],
    'createAuthor' =>
        [
            'path' => '/author',
            'method' => 'POST',
            'controller' => 'AuthorController',
            'action' => 'create',
        ],
    'updateAuthor' =>
        [
            'path' => '/author/:id',
            'method' => 'PUT',
            'controller' => 'AuthorController',
            'action' => 'update',
        ],
    'deleteAuthor' =>
        [
            'path' => '/author/:id',
            'method' => 'DELETE',
            'controller' => 'AuthorController',
            'action' => 'delete',
        ],
    'publishers' =>
        [
            'path' => '/publisher/:id',
            'method' => 'GET',
            'controller' => 'PublisherController',
            'action' => 'show',
        ],
    'createPublisher' =>
        [
            'path' => '/publisher',
            'method' => 'POST',
            'controller' => 'PublisherController',
            'action' => 'create',
        ],
    'updatePublisher' =>
        [
            'path' => '/publisher/:id',
            'method' => 'PUT',
            'controller' => 'PublisherController',
            'action' => 'update',
        ],
    'deletePublisher' =>
        [
            'path' => '/publisher/:id',
            'method' => 'DELETE',
            'controller' => 'PublisherController',
            'action' => 'delete',
        ],
];