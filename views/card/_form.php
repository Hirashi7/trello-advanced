<?php
    $labelNames = [];
    foreach ($this->data->labels as $key => $value) {
        $labelNames[] = $value;
    }

?>
<form action="" method="POST">
    <div class="form-group">
        <label>Nazwa</label>
        <input type="text" name="name" class="form-control" value="<?= $this->data->name;?>" required>
    </div>
    <div class="form-group">
        <label>Opis</label>
        <textarea name="desc" class="form-control" required><?= $this->data->description;?></textarea>
    </div>
    <div class="form-group">
        <label>Lista</label>
        <select name="idList" required class="form-control">
            <?php foreach ($this->data->lists as $list): ?>
                <option value="<?= $list->id; ?>" <?php if($this->data->idList == $list->id) echo 'selected'; ?>>
                    <?= $list->name;?>
                </option>
            <?php endforeach;?>
        </select>
    </div>
    <div class="form-group">
        <label>Etykiety</label>
        <select name="idLabels[]" required class="form-control" multiple>
            <?php foreach ($this->data->labelList as $label): ?>
                <option value="<?= $label->id; ?>" <?php if(in_array($label->name, $labelNames)) echo 'selected'; ?>>
                    <?= $label->name;?>
                </option>
            <?php endforeach;?>
        </select>
    </div>
    <p><button type="submit" class="btn btn-success" name="submit">Zapisz</button></p>
</form>