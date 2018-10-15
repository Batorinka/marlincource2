<?php

use App\QueryBuilder;

$db = new QueryBuilder();

$posts = $db->getOne(1, 'posts');

var_dump($posts['title']);
