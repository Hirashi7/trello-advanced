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
        $board->updateDb();

        foreach ($lists as $item) {
            $item->updateDb();
        }

        foreach ($labels as $item) {
            $item->updateDb();
        }

        foreach ($cards as $item) {
            $item->updateDb();
        }
    }

    // public function saveBoards(array $items): ?string {
    //     if(sizeof($items) === 0) {
    //         return null;
    //     }

    //     $sql = '';
    //     foreach ($items as $item) {
    //        $sql .= $item->getSaveSql();
    //     }

    //     return $sql;
    // }

    // public function saveLists(array $items): ?string {
    //     if(sizeof($items) === 0) {
    //         return null;
    //     }

    //     $sql = '';
    //     foreach ($items as $item) {

    //         $sql .= $item->getSaveSql();
    //     }

    //     return $sql;
    // }

    // public function saveLabels(array $items): ?string {
    //     if(sizeof($items) === 0) {
    //         return null;
    //     }

    //     $sql = '';
    //     foreach ($items as $item) {

    //         $sql .= $item->getSaveSql();
    //     }

    //     return $sql;
    // }

    // public function saveCards(array $items): ?string {
    //     if(sizeof($items) === 0) {
    //         return null;
    //     }

    //     $sql = '';
    //     foreach ($items as $item) {

    //         $sql .= $item->getSaveSql();
    //     }

    //     return $sql;
    // }
}