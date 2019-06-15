<?php
use Core\Model;

class Board extends Model {
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $desc;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $dateLastActivity;

    /**
     * @return Card[]
     */
    public function getCards(): ?array {
        return $this->get("boards/{$this->id}/cards", Card::class);
    }

    /**
     * @return BoardList[]
     */
    public function getLists(): ?array {
        return $this->get("boards/{$this->id}/lists", BoardList::class);
    }

    /**
     * @return Label[]
     */
    public function getLabels(): ?array {
        return $this->get("boards/{$this->id}/labels", Label::class);
    }

    public function updateDb() {
        $sql = "
            INSERT INTO boards 
            (id, name, description, url, dateLastActivity) 
            VALUES (
                '{$this->id}',
                '{$this->name}',
                '{$this->desc}',
                '{$this->url}',
                '{$this->dateLastActivity}'
            ) ON DUPLICATE KEY UPDATE 
                name = '{$this->name}',
                description = '{$this->desc}',
                url = '{$this->url}',
                dateLastActivity = '{$this->dateLastActivity}';
        ";
        $request = $this->db->insert($sql);
        return $request;
    }
}