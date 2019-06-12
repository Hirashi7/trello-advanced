<?php
use Core\Controller;

class LabelController extends Controller {
    public function indexAction() {
        $sql = "
            SELECT labels.id as id, labels.name as name, labels.idBoard as boardId, boards.name as boardName
            FROM labels 
            INNER JOIN boards
            ON boards.id = labels.idBoard
            WHERE labels.name != ''
        ";
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }
        $this->render('index', $data);
    }

    public function viewAction($id) {
        if($id == null || empty($id)){
            header('location: /label');
            exit;
        }
        $sql = "
            SELECT labels.id as id, labels.name as name, boards.id as boardId
            FROM labels 
            INNER JOIN boards
            ON boards.id = labels.idBoard
            WHERE labels.id = '{$id}'
        ";
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }
        $this->render('view', $data[0]);
    }

    public function editAction($id) {
        if($id == null || empty($id)){
            header('location: /label');
            exit;
        }

        if(isset($_POST['submit'])) {
            $updateSql = "
                UPDATE labels
                SET name = '{$_POST['name']}'
                WHERE id = '{$id}'
            ";
            $update = $this->db->update($updateSql);
            if($update) {
                $trelloRequest = Label::update($id, $_POST);
                if($trelloRequest) {
                    $this->messages->push('Sukces! Rekord zaktualizowany poprawnie.', 'success');
                    header('location: /label');
                    exit;
                }else {
                    $this->messages->push('Problem z aktualizacją danych w Trello', 'warning');
                }
            }else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }

        $sql = "
            SELECT labels.id as id, labels.name as name, boards.id as boardId
            FROM labels 
            INNER JOIN boards
            ON boards.id = labels.idBoard
            WHERE labels.id = '{$id}'
        ";
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }
        $this->render('edit', $data[0]);
    }

    public function addAction() {
        $data = new Label();


        $this->render('add', $data);
    }



}