<?php

use Core\ApiController;

class ApiTrelloController extends ApiController
{

    public function index() {
        $member = new Member();
        $board = Board::filterBoardByName($member->getBoards(), 'Projekt IT');
        $cards = $board->getCards();
    }

}