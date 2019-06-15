<?php

use Core\ApiController;

class ApiTrelloController extends ApiController
{

    public function index() {
        echo 'Trello Api';
    }

    public function fetch() {
        $this->db->delete("
            SET FOREIGN_KEY_CHECKS = 0; 
            TRUNCATE TABLE cards_has_labels;
            TRUNCATE TABLE cards;
            TRUNCATE TABLE labels;
            TRUNCATE TABLE lists;
            TRUNCATE TABLE boards;
            SET FOREIGN_KEY_CHECKS = 1; 
        ");
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
    
    public function automate() {
        $member = new Member();
        $board = Board::filterByName($member->getBoards(), 'Projekt IT')[0];
        $lists = $board->getLists();
        $labels = $board->getLabels();
        $cards = $board->getCards();

        $supporLabel = Label::filterByName($labels, 'Opieka')[0];
        $warrantyLabel = Label::filterByName($labels, 'Gwarancja')[0];
        $backlogList = BoardList::filterByName($lists, 'BACKLOG')[0];
        $todoList = BoardList::filterByName($lists, 'DO ZROBIENIA')[0];

        foreach ($cards as $card) {
            if($card->idList !== $backlogList->id){
                continue;
            }
            
            $labelFlag = false;
            $warrantyFlag = false;
            foreach ($card->idLabels as $label) {
                if($label == $supporLabel->id) {
                    $labelFlag = true;
                }
                if($label == $warrantyLabel->id) {
                    $warrantyFlag = true;
                }
            }

            $name = $card->name;
            $due = $card->due;
            $time = null;

            if((strpos($name, "{") && strpos($name, "}")) && (strpos($name, "}") > strpos($name, "{"))){
                $timeStart = strpos($name, "{") + 1;
                $timeLength = strpos($name, "}") - $timeStart;
                $time = substr($name, $timeStart, $timeLength);
                $name = str_replace('{' . $time . '}', '', $name);
                $time = str_replace(['+','d'],'', $time); 
                $time = intval($time);
           }

            // opieka/gwarancja + brak daty + brak definicji czasu
           if(($labelFlag || $warrantyFlag) && $due == null && $time == null) {
            $daysOffset = 2;
            $dayOfWeek = intval(date('w'));
            if($dayOfWeek > 3) $daysOffset += 2;
            $due = new DateTime();
            $due = $due->modify("+{$daysOffset} days");
            $due = $due->format(DateTime::ATOM);
           }

           // inne + brak daty + brak definicji czasu
           if(!$labelFlag && $due == null && $time == null){
            $due = new DateTime();
            $due = $due->modify("+14 days");
            $due = $due->format(DateTime::ATOM);
           }

           // cokolwiek + brak daty + definicja czasu
           if($due == null && $time != null) {
            $daysOffset = $time;
            $dayOfWeek = intval(date('w'));
            if($dayOfWeek > 3) $daysOffset += 2;
            $due = new DateTime();
            $due = $due->modify("+{$daysOffset} days");
            $due = $due->format(DateTime::ATOM);
           }

           if($labelFlag || $warrantyFlag){
            Card::makeRequest("cards/{$card->id}", [
                'name' => $name,
                'idList' => $todoList->id,
                'due' => $due
            ], 'PUT');
           } else {
            Card::makeRequest("cards/{$card->id}", [
                'name' => $name,
                'due' => $due
            ], 'PUT');
           }

            
            
        }
    } 

    public function indexTasks() {
        $member = new Member();
        $board = Board::filterByName($member->getBoards(), 'Projekt IT')[0];
        $cards = $board->getCards();
        $dbCards = $this->db->select("SELECT id, number FROM cards");
        $numbers = [];

        foreach ($dbCards as $dbCard) {
            $numbers[$dbCard->id] = $dbCard->number;
        }

        foreach ($cards as $card) {
            $name = $card->name;
            $hasNumber = false;

            if((strpos($name, "[") > -1 && strpos($name, "]") > -1) && (strpos($name, "]") > strpos($name, "["))){
                $numberStart = strpos($name, "[") + 1;
                $numberLength = strpos($name, "]") - $numberStart;
                $number = substr($name, $numberStart, $numberLength);
                $number = str_replace(['#'],'', $number); 
                $number = intval($number);
                $hasNumber = true;
                
           }

            if(!$hasNumber) {
                $name = "[#{$numbers[$card->id]}] {$name}"; 
            }

            Card::makeRequest("cards/{$card->id}", [
                'name' => $name
            ], 'PUT');
        }
    }

    public function unindexTasks() {
        $member = new Member();
        $board = Board::filterByName($member->getBoards(), 'Projekt IT')[0];
        $cards = $board->getCards();

        foreach ($cards as $card) {
            $name = $card->name;

            if((strpos($name, "[") > -1 && strpos($name, "]") > -1) && (strpos($name, "]") > strpos($name, "["))){
                $numberStart = strpos($name, "[") + 1;
                $numberLength = strpos($name, "]") - $numberStart;
                $number = substr($name, $numberStart, $numberLength);
                $name = str_replace("[" . $number . "]",'', $name); 
           }

            Card::makeRequest("cards/{$card->id}", [
                'name' => $name
            ], 'PUT');
        }
    }
}