<?php
use Core\Model;

class Card extends Model {
    public $id = '';
    public $name = '';
    public $desc = '';
    public $idBoard = '';
    public $idList = '';
    public $idLabels = [];
    public $labels = [];
    public $url = '';
    public $due = '';
    public $idMembers;


    public function updateDb() {
        $sql = "
        DELETE FROM cards_has_labels
        WHERE cards_id = '{$this->id}';
    
        INSERT INTO cards 
            (id, name, description, idBoard, idList, url, due) 
            VALUES (
                '{$this->id}',
                '{$this->name}',
                '{$this->desc}',
                '{$this->idBoard}',
                '{$this->idList}',
                '{$this->url}',
                '{$this->due}'
            ) ON DUPLICATE KEY UPDATE 
                name = '{$this->name}',
                description = '{$this->desc}',
                idBoard = '{$this->idBoard}',
                idList = '{$this->idList}',
                url = '{$this->url}',
                due = '{$this->due}';
        ";

        foreach ($this->labels as $label) {
            $sql .= "
                INSERT INTO cards_has_labels
                (cards_id, labels_id)
                VALUES
                ('{$this->id}','{$label->id}');
            ";
        }

        $result = $this->db->insert($sql);

        return $result;
    }

    public static function update($id, $data) {
        if($id == null || $data == null || empty($data)) {
            return false;
        }

        $trelloSave = self::makeRequest("cards/{$id}", $data, 'PUT');
        if($trelloSave === false) return false;

        $object = self::get("cards/{$id}");
        $dbSave = $object->updateDb();

        return $trelloSave && $dbSave;
    }

    public static function add($data) {
        if($data == null || empty($data)) {
            return false;
        }

        $trelloSave = self::makeRequest('cards', $data, 'POST');
        if($trelloSave === false) return false;

        $object = self::get("cards/{$trelloSave->id}");
        $dbSave = $object->updateDb();

        return $trelloSave && $dbSave;

    }

    public static function delete($id) {
        if ($id == null || empty($id)) {
            return false;
        }
        $delete = self::makeRequest("cards/{$id}", null, "DELETE");
        if ($delete === false) return false;
        $object = new Card();

        $sql = "
            DELETE FROM cards_has_labels
            WHERE cards_id = '{$id}';
            DELETE FROM cards WHERE id = '{$id}';
        ";

        return $object->db->delete($sql);
    }
}