<?php $this->layout('layout', ['title' => "Post #{$post['id']}"]) ?>

<h1>Post #<?=$this->e($post['id'])?></h1>
<h3><?=$this->e($post['title'])?></h3>