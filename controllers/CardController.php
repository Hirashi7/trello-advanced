<?php
use Core\Controller;

class CardController extends Controller {
    /**
     * @throws Exception
     */
    public function indexAction() {
        $sql = "
        SELECT
        c.id as id,
        c.name as name,
        c.description as description,
        c.url as url,
        c.idBoard as idBoard,
        c.idList as idList,
        b.name as boardName, 
        l.name as listName,
        lb.name as labelName
        FROM `cards_has_labels` as chl
        INNER JOIN cards as c
        ON chl.cards_id = c.id
        INNER JOIN boards as b
        ON c.idBoard = b.id
        INNER JOIN lists as l
        ON l.id = c.idList
        INNER JOIN labels as lb
        ON lb.id = chl.labels_id
        ";
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }
        
        $items = [];
        foreach ($data as $item) {
            $item = (array) $item;
            if(!isset($items[$item['id']])){
                $items[$item['id']] = $item;
                $items[$item['id']]['labels'][] = $item['labelName'];
            }else{
                $items[$item['id']]['labels'][] = $item['labelName'];
            }
        }
        $items = array_values($items);
        foreach ($items as $key => $item) {
            $items[$key] = (object) $item;
        }
        $this->render('index', $items);
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function viewAction($id) {
        if($id == null || empty($id)){
            header('location: /card');
            exit;
        }
        $sql = "
            SELECT
            c.id as id,
            c.name as name,
            c.description as description,
            c.url as url,
            c.idBoard as idBoard,
            c.idList as idList,
            b.name as boardName, 
            l.name as listName,
            lb.name as labelName
            FROM `cards_has_labels` as chl
            INNER JOIN cards as c
            ON chl.cards_id = c.id
            INNER JOIN boards as b
            ON c.idBoard = b.id
            INNER JOIN lists as l
            ON l.id = c.idList
            INNER JOIN labels as lb
            ON lb.id = chl.labels_id
            WHERE c.id = '{$id}'
        ";
        
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }

        $items = [];
        foreach ($data as $item) {
            $item = (array) $item;
            if(!isset($items[$item['id']])){
                $items[$item['id']] = $item;
                $items[$item['id']]['labels'][] = $item['labelName'];
            }else{
                $items[$item['id']]['labels'][] = $item['labelName'];
            }
        }
        $items = array_values($items);
        foreach ($items as $key => $item) {
            $items[$key] = (object) $item;
        }

        $this->render('view', $items[0]);
    }

    /**
     * @param $id
     * @throws Exception
     */
    public function editAction($id) {
        if($id == null || empty($id)){
            header('location: /card');
            exit;
        }

        if(isset($_POST['submit'])) {
            $update = Card::update($id, $_POST);
            if($update) {
                $this->messages->push('Sukces! Rekord zaktualizowany poprawnie.', 'success');
                    header('location: /card');
                    exit;
            } else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }

        $sql = "
            SELECT
            c.id as id,
            c.name as name,
            c.description as description,
            c.url as url,
            c.idBoard as idBoard,
            c.idList as idList,
            b.name as boardName, 
            l.name as listName,
            lb.name as labelName
            FROM `cards_has_labels` as chl
            INNER JOIN cards as c
            ON chl.cards_id = c.id
            INNER JOIN boards as b
            ON c.idBoard = b.id
            INNER JOIN lists as l
            ON l.id = c.idList
            INNER JOIN labels as lb
            ON lb.id = chl.labels_id
            WHERE c.id = '{$id}'
        ";
        
        $data = $this->db->select($sql);
        if($data == null || sizeof($data) < 1) {
            $data = [];
        }

        $items = [];
        foreach ($data as $item) {
            $item = (array) $item;
            if(!isset($items[$item['id']])){
                $items[$item['id']] = $item;
                $items[$item['id']]['labels'][] = $item['labelName'];
            }else{
                $items[$item['id']]['labels'][] = $item['labelName'];
            }
        }
        
        $items = array_values($items);
        foreach ($items as $key => $item) {
            $items[$key] = (object) $item;
        }

        $data = $items;

        $boardsSql = "
            SELECT * FROM boards;
        ";
        $labelsSql = "
            SELECT * FROM labels
            WHERE name != '';
        ";
        $listsSql = "
            SELECT * FROM lists;
        ";

        $boards = $this->db->select($boardsSql);
        $labels = $this->db->select($labelsSql);
        $lists = $this->db->select($listsSql);
        
        if($boards == null || sizeof($boards) < 1) {
            $boards = [];
        }
        $data[0]->boards = $boards;

        if($labels == null || sizeof($labels) < 1) {
            $labels = [];
        }
        $data[0]->labelList = $labels;

        if($lists == null || sizeof($lists) < 1) {
            $lists = [];
        }
        $data[0]->lists = $lists;
        $this->render('edit',  $data[0]);
    }

    /**
     * @throws Exception
     */
    public function addAction() {
        if(isset($_POST['submit'])) {
            $update = Card::add($_POST);
            if($update) {
                $this->messages->push('Sukces! Rekord został dodany poprawnie.', 'success');
                    header('location: /card');
                    exit;
            } else {
                $this->messages->push('Błędne dane. Spróbuj jeszcze raz', 'danger');
            }
        }
        $data = new Card();
        $data->description = $data->desc;
        $boardsSql = "
            SELECT * FROM boards;
        ";
        $labelsSql = "
            SELECT * FROM labels
            WHERE name != '';
        ";
        $listsSql = "
            SELECT * FROM lists;
        ";

        $boards = $this->db->select($boardsSql);
        $labels = $this->db->select($labelsSql);
        $lists = $this->db->select($listsSql);
        
        if($boards == null || sizeof($boards) < 1) {
            $boards = [];
        }
        $data->boards = $boards;

        if($labels == null || sizeof($labels) < 1) {
            $labels = [];
        }
        $data->labelList = $labels;

        if($lists == null || sizeof($lists) < 1) {
            $lists = [];
        }
        $data->lists = $lists;
        $this->render('add',  $data);
    }

    /**
     * @param $id
     */
    public function deleteAction($id) {
       $request = Card::delete($id);
       if($request){
            $this->messages->push('Sukces! Rekord usunięty poprawnie.', 'success');
       } else {
            $this->messages->push('Nie udało się usunąć rekordu. Spróbój jeszcze raz.', 'danger');
       }
       header('location: /card');
       exit;
    }



}