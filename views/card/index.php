<div class="container">
    <div class="row">
        <div class="col-12">
        <h1>Zadania - Lista</h1>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="/">Strona główna</a>
            <span class="breadcrumb-item active">Zadania</span>
        </nav>
        </div>
        <p class="col-12">
            <a href="/card/add" class="btn btn-outline-success">Dodaj</a>
        </p>
        <div class="col-12">
            <table class="table table-stripped">
                <thead>
                    <tr>
                        <th class="text-muted">#</th>
                        <th>Nazwa</th>
                        <th>Lista</th>
                        <th>Tablica</th>
                        <th>Etykiety</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $counter = 1;
                    foreach ($this->data as $item): ?>
                        <tr>
                            <td class="text-muted"><?= $counter; ?></td>
                            <td><?= $item->name; ?></td>
                            <td><?= $item->listName; ?></td>
                            <td><?= $item->boardName; ?></td>
                            <td>
                                <?php foreach($item->labels as $label): ?>
                                    <span class="badge badge-default"><?= $label;?></span>
                                <?php endforeach; ?>
                            </td>
                            <td class="text-right"><div class="btn-group">
                                <a href="/card/view/<?= $item->id; ?>" class="btn btn-primary">Zobacz</a>
                                <a href="/card/edit/<?= $item->id; ?>" class="btn btn-warning">Edytuj</a>
                                <a href="/card/delete/<?= $item->id; ?>" class="btn btn-danger">Usuń</a>
                            </div></td>
                        </tr>
                    <?php 
                        $counter++;
                        endforeach;
                    ?>
                </tbody>
            </table>
            <p class="small text-muted">Wyświetlono: <strong><?= sizeof($this->data); ?></strong></p>
        </div>
    </div>
</div>