<div class="container">
    <div class="row">
        <div class="col-12">
        <h1>Etykiety - <strong><?= $this->data->name; ?></strong></h1>
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="/">Strona główna</a>
            <a class="breadcrumb-item" href="/label">Etykiety</a>
            <span class="breadcrumb-item active"><?= $this->data->name; ?></span>
        </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?php require_once '_form.php'?>
        </div>
    </div>
</div>