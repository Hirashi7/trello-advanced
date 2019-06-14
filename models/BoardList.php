<?php

use Core\Model;

class BoardList extends Model {
    public $id;
    public $name;

    public function updateDb() {
        $sql = "
            INSERT INTO lists 
            (id, name) 
            VALUES (
                '{$this->id}',
                '{$this->name}'
            ) ON DUPLICATE KEY UPDATE 
                id = '{$this->id}',
                name = '{$this->name}';
        ";
        $request = $this->db->insert($sql);
        return $request;
    }
}