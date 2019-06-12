<?php
use Core\Model;

class Card extends Model {
    public $id;
    public $name;
    public $desc;
    public $idBoard;
    public $idList;
    public $idLabels;
    public $labels;
    public $url;
    public $due;
    public $idMembers;

    public function getSaveSql() {
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

        return $sql;
    }
}