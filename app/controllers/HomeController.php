<?php
namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use Delight\Auth\Auth;
use PDO;

class HomeController {
  
  private $templates;
  private $auth;
  private $qb;
  
  public function __construct(QueryBuilder $qb, Engine $engine, Auth $auth)
  {
    $this->templates = $engine; 
    $this->auth = $auth;
    $this->qb = $qb;
    $_SESSION['auth_logged_in'] = $this->auth->isLoggedIn();
  }
  
  public function index()
  {
    $posts = $this->qb->getAll('posts');
    
    echo $this->templates->render('homepage', ['posts' => $posts]);
  }
  
  public function about()
  {
    echo $this->templates->render('about', ['name' => 'Kirill']);
  }
  
  public function post($vars)
  {
    $post = $this->qb->getOne($vars['id'], 'posts');
    
    echo $this->templates->render('post', [
      'post' => $post
    ]);
  }
  
  public function addPostForm()
  {
    echo $this->templates->render('addPost', ['name' => 'Kirill']);
  }
  
  public function addPost()
  {
    $this->qb->insert(['title' => $_POST['title']], 'posts');
    flash()->message('Post was add');
    $this->index();
  }
  
  public function deletePost($vars)
  {
    $this->qb->delete($vars['id'], 'posts');
    flash()->message("Post #{$vars['id']} was delete");
    $this->index();
  }
  
  public function updateForm($vars)
  {
    $post = $this->qb->getOne($vars['id'], 'posts');
    
    echo $this->templates->render('updatePost', [
      'post' => $post
    ]);
  }
  
  public function updatepost($vars)
  {
    $this->qb->update(['title' => $_POST['title']], $vars['id'], 'posts');
    flash()->message('Post was update');
    $this->index();
  }
  
  public function loginForm()
  {
    echo $this->templates->render('auth', ['name' => 'Kirill']);
  }
  
  public function auth()
  {
    try {
    $userId = $this->auth->register('batorinka@list1.ru', '123', 'Kirill', function ($selector, $token) {
        echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
    });

    echo 'We have signed up a new user with the ID ' . $userId;
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        die('Invalid email address');
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        die('Invalid password');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('User already exists');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
  }
  
  public function email_verification()
  {
    try {
      $this->auth->confirmEmail('BlS_AhxpIsDZkf9j', '2DqVDaFAWkSB1AQp');

      echo 'Email address has been verified';
    }
    catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
        die('Invalid token');
    }
    catch (\Delight\Auth\TokenExpiredException $e) {
        die('Token expired');
    }
    catch (\Delight\Auth\UserAlreadyExistsException $e) {
        die('Email address already exists');
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        die('Too many requests');
    }
  }
  
  public function login() 
  {
    try {
        $this->auth->login($_POST['email'], $_POST['password']);
        flash()->message('User is logged in');
        $this->index();
    }
    catch (\Delight\Auth\InvalidEmailException $e) {
        flash()->error('Wrong email address');
        $this->auth();
    }
    catch (\Delight\Auth\InvalidPasswordException $e) {
        flash()->error('Wrong password');
        $this->auth();
    }
    catch (\Delight\Auth\EmailNotVerifiedException $e) {
        flash()->error('Email not verified');
        $this->auth();
    }
    catch (\Delight\Auth\TooManyRequestsException $e) {
        flash()->error('Too many requests');
        $this->auth();
    }
  }
  
  public function logout()
  {
    $this->auth->logOut();
    flash()->message('User is logged out');
    $this->index();
  }
}
