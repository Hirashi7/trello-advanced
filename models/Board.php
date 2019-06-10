<?php
use Core\Model;

class Board extends Model {
    public $id;
    public $name;
    public $cards;
    public $lists;
    public $labels;

    public function getCards(): array {
        // TODO
    }
    
    public static function filterBoardByName(array $boards, string $name): ?Board {
        $board = array_filter($boards, function($el) use ($name) {
            return $el->name === $name;
        } );
        $board = array_values($board);
        return sizeof($board) > 0 ? $board[0] : null;
    }
}