<form action="" method="POST">
    <div class="form-group">
        <label>Nazwa</label>
        <input type="text" name="name" class="form-control" value="<?= $this->data->name;?>" required>
    </div>
    <p><button type="submit" class="btn btn-success" name="submit">Zapisz</button></p>
</form>