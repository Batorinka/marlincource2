<?php $this->layout('layout', ['title' => 'Add Post']) ?>

<h1>Add Post</h1>

<form action="/addpost" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Название</label>
    <input type="text" name="title" class="form-control" placeholder="Введите название">
  </div>
  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
