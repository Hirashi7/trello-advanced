<?php

use Core\Model;

class Label extends Model
{
    public $id = '';
    public $name = '';
    public $color = '';
    public $idBoard = '';
    public $boards = [];

    /**
     * @return bool
     */
    public function updateDb() {
        $sql = "
            INSERT INTO labels 
            (id, name, color, idBoard) 
            VALUES (
                '{$this->id}',
                '{$this->name}',
                '{$this->color}',
                '{$this->idBoard}'
            ) ON DUPLICATE KEY UPDATE 
                id = '{$this->id}',
                name = '{$this->name}',
                color = '{$this->color}',
                idBoard = '{$this->idBoard}';
        ";
        $result = $this->db->insert($sql);
        return $result;
    }

    public static function update($id, $data) {
        if($id == null || $data == null || empty($data)) {
            return false;
        }

        $trelloSave = self::makeRequest("label/{$id}", $data, 'PUT');
        if($trelloSave === false) return false;


        $object = self::get("label/{$id}");
        $dbSave = $object->updateDb();

        return $trelloSave && $dbSave;
    }

    public static function add($data) {
        if($data == null || empty($data)) {
            return false;
        }

        $trelloSave = self::makeRequest('labels', $data, 'POST');
        if($trelloSave === false) return false;

        $object = self::get("label/{$trelloSave->id}");
        $dbSave = $object->updateDb();

        return $trelloSave;

    }

    public static function delete($id){
        if ($id == null || empty($id)) {
            return false;
        }
        $delete = self::makeRequest("labels/{$id}", null, "DELETE");
        if ($delete === false) return false;
        $object = new Label();

        $sql = "
            DELETE FROM labels WHERE id = '{$id}';
        ";

        return $object->db->delete($sql);
    }
}
