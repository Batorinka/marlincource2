<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>Posts</h1>


<?php foreach($posts as $post): ?>
<a href="/post/<?= $post['id'] ?>"><?= $post['title'] ?></a>
<?php endforeach; ?>