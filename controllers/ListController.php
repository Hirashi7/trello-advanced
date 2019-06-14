<?php
use Core\Controller;

class ListController extends Controller {
    public function indexAction() {
        $sql = "
            SELECT *
            FROM lists 
            WHERE lists.name != ''
        ";
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }
        $this->render('index', $data);
    }

    public function viewAction($id) {
        if($id == null || empty($id)){
            header('location: /list');
            exit;
        }
        $sql = "
            SELECT *
            FROM lists 
            WHERE lists.id = '{$id}'
        ";
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }
        $this->render('view', $data[0]);
    }

    public function editAction($id) {
        if($id == null || empty($id)){
            header('location: /list');
            exit;
        }

        if(isset($_POST['submit'])) {
            $update = BoardList::update($id, $_POST);
            if($update) {
                $this->messages->push('Sukces! Rekord zaktualizowany poprawnie.', 'success');
                    header('location: /list');
                    exit;
            } else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }

        $sql = "
            SELECT *
            FROM lists 
            WHERE lists.id = '{$id}'
        ";
        $data = $this->db->select($sql);

        if($data == null || sizeof($data) < 1) {
            $data = [];
        }

        $this->render('edit',  $data[0]);
    }

    public function addAction() {
        $data = new BoardList();

        $boardsSql = "
            SELECT * FROM boards;
        ";
        $boards = $this->db->select($boardsSql);
        if($boards == null || sizeof($boards) < 1) {
            $boards = [];
        }
        $data->boards = $boards;

        if(isset($_POST['submit'])){
            $update = BoardList::add($_POST);
            if($update) {
                $this->messages->push('Sukces! Rekord dodany poprawnie.', 'success');
                    header('location: /list');
                    exit;
            } else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }
        $this->render('add', $data);
    }

    public function deleteAction($id) {
       $request = BoardList::delete($id);
       var_dump($request);
       if($request){
            $this->messages->push('Sukces! Rekord usunięty poprawnie.', 'success');
       } else {
            $this->messages->push('Nie udało się usunąć rekordu. Spróbój jeszcze raz.', 'danger');
       }
       header('location: /list');
       exit;
    }



}