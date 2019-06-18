<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="jumbotron">
                <h1 class="display-4">Panel zarządzania zadaniami w trello</h1>
                <p class="lead">Autor: Grzegorz Wójcik w57104</p>
                <hr>
                <p class="lead">W ramach aplikacji udostępnione zostało API, które należy podłączyć pod mechanizm CRON na serwerze</p>
                <p>
                Wymazuje obecne dane z bazy i pobiera aktualne<br>
                    <code>/api/trello/<b>fetch</b></code><br>
                   
                    <a href="/api/trello/fetch" target="_blank" class="btn btn-outline-success">Synchronizacja</a>
                </p>
                <p>
                Przenosi zadania i parsuje ustawione daty wedle reguł (szczegóły w sprawozdaniu) <br>
                    <code>/api/trello/<b>automate</b></code><br>
                    <a href="/api/trello/automate" target="_blank" class="btn btn-outline-primary">Automatyzacja zadań</a>
                </p>
                <p>
                    Dodaje numery zadań do wszystkich kart w określonej tablicy <br>
                    <code>/api/trello/<b>indexTasks</b></code><br>
                    <a href="/api/trello/indexTasks" target="_blank" class="btn btn-outline-warning">Numeracja zadań</a>
                </p>
                <p>
                    Usuwa numery zadań ze wszystkich kart w określonej tablicy <br>
                    <code>/api/trello/<b>unindexTasks</b></code><br>
                    <a href="/api/trello/unindexTasks" target="_blank" class="btn btn-outline-danger">Odnumerowanie zadań</a>
                </p>
            </div>
        </div>
    </div>
</div>