<?php

use Core\ApiController;

class ApiTrelloController extends ApiController
{

    public function index() {
        $member = new Member();
        $board = Board::filterByName($member->getBoards(), 'Projekt IT')[0];
        $lists = $board->getLists();
        $labels = $board->getLabels();
        $cards = $board->getCards();
        echo '<pre>';
        var_dump($this->db->insert($this->saveBoards([$board])));
        var_dump($this->db->insert($this->saveLists($lists)));
        var_dump($this->db->insert($this->saveLabels($labels)));
        var_dump($this->db->insert($this->saveCards($cards)));
        echo '</pre>';

    }

    public function saveBoards(array $items): ?string {
        if(sizeof($items) === 0) {
            return null;
        }

        $sql = '';
        foreach ($items as $item) {
           $sql .= $item->getSaveSql();
        }

        return $sql;
    }

    public function saveLists(array $items): ?string {
        if(sizeof($items) === 0) {
            return null;
        }

        $sql = '';
        foreach ($items as $item) {

            $sql .= $item->getSaveSql();
        }

        return $sql;
    }

    public function saveLabels(array $items): ?string {
        if(sizeof($items) === 0) {
            return null;
        }

        $sql = '';
        foreach ($items as $item) {

            $sql .= $item->getSaveSql();
        }

        return $sql;
    }

    public function saveCards(array $items): ?string {
        if(sizeof($items) === 0) {
            return null;
        }

        $sql = '';
        foreach ($items as $item) {

            $sql .= $item->getSaveSql();
        }

        return $sql;
    }
}