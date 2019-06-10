<?php


interface IdentityServiceInterface
{
    function isUserValid(string $email, string $password): bool;

    function isUserLoggedIn(): bool;

    function logIn(string $email, string $password);

    function logOut();

    function setDatabaseConnection(DbConnectionInterface $db_connection);

}