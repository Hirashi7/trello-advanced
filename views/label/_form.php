<?php
    $colors = [
        'red' => 'Czerwony',
        'orange' => 'Pomarańczowy',
        'green' => 'Zielony',
        'yellow' => 'Żółty',
        'purple' => 'Fioletowy',
        'blue' => 'Niebieski'
    ];
?>
<form action="" method="POST">
    <div class="form-group">
        <label>Nazwa</label>
        <input type="text" name="name" class="form-control" value="<?= $this->data->name;?>" required>
    </div>
    <div class="form-group">
        <label>Kolor</label>
        <select name="color" value="<?= $this->data->color;?>" required class="form-control">
            <?php foreach ($colors as $key => $color): ?>
                <option value="<?= $key;?>" <?php if($key == $this->data->color) echo 'selected'; ?>><?= $color;?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label>Projekt</label>
        <select name="idBoard" value="<?= $this->data->idBoard;?>" required class="form-control">
            <?php foreach ($this->data->boards as $board): ?>
                <option value="<?= $board->id;?>" <?php if($board->id == $this->data->idBoard) echo 'selected';?>><?= $board->name;?></option>
            <?php endforeach;?>
        </select>
    </div>
    <p><button type="submit" class="btn btn-success" name="submit">Zapisz</button></p>
</form>