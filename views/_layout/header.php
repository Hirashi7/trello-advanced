<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trello Advanced</title>
    <?= $this->head(); ?>
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container justify-content-between">
                <a class="navbar-brand" href="/">Panel zarządzania zadaniami Trello</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#mainMenuCollapse" aria-controls="mainMenuCollapse"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="mainMenuCollapse">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Start <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Zadania</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown1">
                        <a class="dropdown-item" href="/card">Wszystkie</a>
                        <a class="dropdown-item" href="/card/add">Dodaj</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Listy</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown2">
                        <a class="dropdown-item" href="/list">Wszystkie</a>
                        <a class="dropdown-item" href="/list/add">Dodaj</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Etykiety</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown3">
                        <a class="dropdown-item" href="/label">Wszystkie</a>
                        <a class="dropdown-item" href="/label/add">Dodaj</a>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </nav>
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?= Messages::display(); ?>
            </div>
        </div>
    </div>

