<div class="container">
    <div class="row">
        <div class="col-12">
        <h1>Listy - <strong><?= $this->data->name; ?></strong></h1>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="/">Strona główna</a>
            <a class="breadcrumb-item" href="/list">Listy</a>
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
                    <td colspan="2" class="text-right">
                        <a href="/list/edit/<?= $this->data->id; ?>" class="btn btn-warning">Edytuj</a>
                        <a href="/list/delete/<?= $this->data->id; ?>" class="btn btn-danger">Usuń</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>