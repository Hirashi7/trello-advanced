<?php

use Core\ApiController;

class ApiTrelloController extends ApiController
{

    /**
     * Index action for routing
     */
    public function index() {
        echo 'Trello Api';
    }

    /**
     * Truncate tables and fetch data from trello api
     */
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
        // get board by user
        $member = new Member();
        // get only one board, filtered by name
        $board = Board::filterByName($member->getBoards(), 'Projekt IT')[0];

        //get list, labels and cards
        $lists = $board->getLists();
        $labels = $board->getLabels();
        $cards = $board->getCards();
        $board->updateDb();

        // run each model save methods
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

    /**
     * Moves to other lists and parses task names by defined rules in method
     * @throws Exception
     */
    public function automate() {
        $member = new Member();
        $board = Board::filterByName($member->getBoards(), 'Projekt IT')[0];
        $lists = $board->getLists();
        $labels = $board->getLabels();
        $cards = $board->getCards();

        // get exact labels for rules
        $supporLabel = Label::filterByName($labels, 'Opieka')[0];
        $warrantyLabel = Label::filterByName($labels, 'Gwarancja')[0];
        // get exact lists for rules
        $backlogList = BoardList::filterByName($lists, 'BACKLOG')[0];
        $todoList = BoardList::filterByName($lists, 'DO ZROBIENIA')[0];

        foreach ($cards as $card) {
            // continue loop only if card is in BACKLOG list
            if($card->idList !== $backlogList->id){
                continue;
            }

            //setting flags of OPIEKA and GWARANCJA labels
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
            // parsing data provided in card name, e.g. "Task number 345 {+2d}" will set "due date" to 2 days from now
            if((strpos($name, "{") && strpos($name, "}")) && (strpos($name, "}") > strpos($name, "{"))){
                $timeStart = strpos($name, "{") + 1;
                $timeLength = strpos($name, "}") - $timeStart;
                $time = substr($name, $timeStart, $timeLength);
                $name = str_replace('{' . $time . '}', '', $name);
                $time = str_replace(['+','d'],'', $time); 
                $time = intval($time);
           }

           if(($labelFlag || $warrantyFlag) && $due == null && $time == null) {
            $daysOffset = 2;
            $dayOfWeek = intval(date('w'));
            if($dayOfWeek > 3) $daysOffset += 2;
            $due = new DateTime();
            $due = $due->modify("+{$daysOffset} days");
            $due = $due->format(DateTime::ATOM);
           }

           if(!$labelFlag && $due == null && $time == null){
            $due = new DateTime();
            $due = $due->modify("+14 days");
            $due = $due->format(DateTime::ATOM);
           }


           if($due == null && $time != null) {
            $daysOffset = $time;
            $dayOfWeek = intval(date('w'));
            if($dayOfWeek > 3) $daysOffset += 2;
            $due = new DateTime();
            $due = $due->modify("+{$daysOffset} days");
            $due = $due->format(DateTime::ATOM);
           }

           // save card to trello
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

    /**
     * Adding numbers to tasks name, eg. [#44]"
     */
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

    /**
     * Remove numbers from tasks name
     */
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