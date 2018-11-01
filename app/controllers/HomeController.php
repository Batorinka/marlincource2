<?php
namespace App\controllers;

use App\QueryBuilder;
use League\Plates\Engine;
use PDO;
use Delight\Auth\Auth;

class HomeController {
  
  private $templates;
  private $auth;
  private $qb;
  
  public function __construct(QueryBuilder $qb, Engine $engine, Auth $auth)
  {
    $this->qb = $qb;
    $this->templates = $engine; 
    $this->auth = $auth;
  }
  
  public function index()
  {
    d($this->templates);die;
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
  
  public function auth()
  {
      echo $this->templates->render('auth', ['name' => 'Kirill']);
//     try {
//     $userId = $this->auth->register('batorinka@list1.ru', '123', 'Kirill', function ($selector, $token) {
//         echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
//     });

//     echo 'We have signed up a new user with the ID ' . $userId;
//     }
//     catch (\Delight\Auth\InvalidEmailException $e) {
//         die('Invalid email address');
//     }
//     catch (\Delight\Auth\InvalidPasswordException $e) {
//         die('Invalid password');
//     }
//     catch (\Delight\Auth\UserAlreadyExistsException $e) {
//         die('User already exists');
//     }
//     catch (\Delight\Auth\TooManyRequestsException $e) {
//         die('Too many requests');
//     }

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
  }
}
