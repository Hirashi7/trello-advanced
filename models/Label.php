<?php

use Core\Model;

class Label extends Model
{
    public $id;
    public $name;
    public $idBoard;

    public function getSaveSql() {
        $sql = "
            INSERT INTO labels 
            (id, name, idBoard) 
            VALUES (
                '{$this->id}',
                '{$this->name}',
                '{$this->idBoard}'
            ) ON DUPLICATE KEY UPDATE 
                id = '{$this->id}',
                name = '{$this->name}',
                idBoard = '{$this->idBoard}';
        ";
        return $sql;
    }

    public static function update($id, $data) {
        if($id == null) {
            return false;
        }

        $request = self::makeRequest("label/{$id}", $data, 'PUT');
        return $request;
    }
}