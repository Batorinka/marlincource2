<?php

require '../vendor/autoload.php';

$templates = new League\Plates\Engine('../app/views');
d($templates);die;
echo $templates->render('homepage', ['name' => 'Jonathan']);