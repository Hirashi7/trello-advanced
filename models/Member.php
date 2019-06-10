<?php
use Core\Model;

class Member extends Model {
    public $id;

    public function getBoards(): ?array {
        $boards = $this->makeRequest('members/me/boards');
        $boards = $this->mapper->mapArray($boards, [], 'Board');
        return sizeof($boards) > 0 ? $boards : null;
    }
}