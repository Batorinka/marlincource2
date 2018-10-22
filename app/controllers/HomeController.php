<?php
namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;

class HomeController {
  
  private $templates;
  
  public function __construct()
  {
    $this->templates = new Engine('../app/views');
  }
  
  public function index()
  {
    $db = new QueryBuilder();
    $posts = $db->getAll('posts');
    
    echo $this->templates->render('homepage', ['posts' => $posts]);
  }
  
  public function about()
  {
    echo $this->templates->render('about', ['name' => 'Kirill']);
  }
  
  public function post($vars)
  {
    $db = new QueryBuilder();
    $post = $db->getOne($vars['id'], 'posts');
    
    echo $this->templates->render('post', [
      'post' => $post
    ]);
  }
}
