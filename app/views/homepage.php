<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>Posts</h1>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Title</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($posts as $post): ?>
    <tr>
      <td>
        <?= $post['id'] ?>
      </td>
      <td>
        <a href="/post/<?= $post['id'] ?>"><?= $post['title'] ?></a>
      </td>
      <td>
        <a href="/deletepost/<?=$post['id'];?>" class="btn btn-danger"
                                onclick="return confirm('are you sure?')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>