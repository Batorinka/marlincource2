<?php $this->layout('layout', ['title' => 'Update Post']) ?>

<h1>Update Post</h1>

<form action="/updatepost/<?=$post['id'];?>" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Название</label>
    <input type="text" name="title" class="form-control" placeholder="Введите название" value="<?=$post['title'];?>">
  </div>
  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
