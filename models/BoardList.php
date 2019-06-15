<?php

use Core\Model;

class BoardList extends Model {
    public $id;
    public $name;
    public $idBoard;

    public function updateDb() {
        $sql = "
            INSERT INTO lists 
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
        $request = $this->db->insert($sql);
        return $request;
    }

    public static function update($id, $data) {
        if($id == null || $data == null || empty($data)) {
            return false;
        }

        $trelloSave = self::makeRequest("lists/{$id}", $data, 'PUT');
        if($trelloSave === false) return false;


        $object = self::get("lists/{$id}");
        $dbSave = $object->updateDb();

        return $trelloSave && $dbSave;
    }

    public static function add($data) {
        if($data == null || empty($data)) {
            return false;
        }

        $trelloSave = self::makeRequest('lists', $data, 'POST');
        if($trelloSave === false) return false;

        $object = self::get("lists/{$trelloSave->id}");
        $dbSave = $object->updateDb();

        return $trelloSave && $dbSave;

    }

    public static function delete($id){
        if ($id == null || empty($id)) {
            return false;
        }
        $delete = self::makeRequest("lists/{$id}/closed", [
            'value' => true
        ], "PUT");
        if ($delete === false) return false;
        $object = new BoardList();

        $sql = "
            DELETE FROM lists WHERE id = '{$id}';
        ";
        return $object->db->delete($sql);
    }
}