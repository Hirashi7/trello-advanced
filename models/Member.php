<?php
use Core\Model;

class Member extends Model {
    public $id;

    /**
     * @return array|null
     * @throws JsonMapper_Exception
     */
    public function getBoards(): ?array {
        $request = $this->makeRequest('members/me/boards');
        $boards = [];
        foreach ($request as $item) {
            $boards[] = $this->mapper->map($item, new Board());
        }

        return $boards;
    }
}