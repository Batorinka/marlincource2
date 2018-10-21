<?php
namespace App\controllers;
use App\QueryBuilder;

class HomeController {
  
  public function index($vars)
  {
    echo $vars['id']; exit;
    $db = new QueryBuilder();
    
    $db->update([
      'title' => 'new post from QueryBuilder package2'
    ], 2, 'posts');
  }
}
