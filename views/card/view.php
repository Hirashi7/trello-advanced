<div class="container">
    <div class="row">
        <div class="col-12">
        <h1>Zadania - <strong><?= $this->data->name; ?></strong></h1>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="/">Strona główna</a>
            <a class="breadcrumb-item" href="/card">Zadania</a>
            <span class="breadcrumb-item active"><?= $this->data->name; ?></span>
        </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered">
                <tr>
                    <th>Identyfikator:</th>
                    <td><?= $this->data->id; ?></td>
                </tr>
                <tr>
                    <th>Nazwa:</th>
                    <td><?= $this->data->name; ?></td>
                </tr>
                <tr>
                    <th>Lista:</th>
                    <td><?= $this->data->listName; ?></td>
                </tr>
                <tr>
                    <th>Tablica:</th>
                    <td><?= $this->data->boardName; ?></td>
                </tr>
                <tr>
                    <th>Etykiety:</th>
                    <td>
                    <?php foreach($this->data->labels as $label): ?>
                        <span class="badge badge-default"><?= $label;?></span>
                    <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="text-right">
                        <a href="/card/edit/<?= $this->data->id; ?>" class="btn btn-warning">Edytuj</a>
                        <a href="/card/delete/<?= $this->data->id; ?>" class="btn btn-danger">Usuń</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>