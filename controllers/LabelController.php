<?php
use Core\Controller;

class LabelController extends Controller {
    public function indexAction() {
        $sql = "
            SELECT labels.id as id, labels.name as name, labels.color as color, labels.idBoard as idBoard, boards.name as boardName
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
            SELECT labels.id as id, labels.name as name, labels.color as color boards.id as idBoard
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
            $update = Label::update($id, $_POST);
            if($update) {
                $this->messages->push('Sukces! Rekord zaktualizowany poprawnie.', 'success');
                    header('location: /label');
                    exit;
            } else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }

        $sql = "
            SELECT labels.id as id, labels.name as name, labels.color as color, boards.id as idBoard
            FROM labels 
            INNER JOIN boards
            ON boards.id = labels.idBoard
            WHERE labels.id = '{$id}'
        ";

        $boardsSql = "
            SELECT * FROM boards;
        ";
        $data = $this->db->select($sql);
        $boards = $this->db->select($boardsSql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }

        if($boards == null || sizeof($boards) < 1) {
            $boards = [];
        }
        $data[0]->boards = $boards;
        $this->render('edit',  $data[0]);
    }

    public function addAction() {
        $data = new Label();

        $boardsSql = "
            SELECT * FROM boards;
        ";
        $boards = $this->db->select($boardsSql);
        if($boards == null || sizeof($boards) < 1) {
            $boards = [];
        }
        $data->boards = $boards;
        if(isset($_POST['submit'])){
            $update = Label::add($_POST);
            if($update) {
                $this->messages->push('Sukces! Rekord dodany poprawnie.', 'success');
                    header('location: /label');
                    exit;
            } else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }
        $this->render('add', $data);
    }

    public function deleteAction($id) {
       $request = Label::delete($id);
       if($request){
            $this->messages->push('Sukces! Rekord usunięty poprawnie.', 'success');
       } else {
            $this->messages->push('Nie udało się usunąć rekordu. Spróbój jeszcze raz.', 'danger');
       }
       header('location: /label');
       exit;
    }



}