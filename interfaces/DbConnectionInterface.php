<?php


interface DbConnectionInterface
{
    /**
     * @param string $command
     * @return mixed
     */
    function select(string $command);

    /**
     * @param string $command
     * @return mixed
     */
    function insert(string $command);

    /**
     * @param string $command
     * @return mixed
     */
    function update(string $command);

    /**
     * @param string $command
     * @return mixed
     */
    function delete(string $command);

}