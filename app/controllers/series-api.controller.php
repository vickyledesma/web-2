<?php
require_once './app/models/task.model.php';
require_once './app/views/api.view.php';

class SeriesApiController {
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new SeriesModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    public function getTasks($params = null) {
        if($_GET["sort"] == "ASC"){
            $series = $this->model->orderAsc();
        }elseif($_GET["sort"] == "DESC"){
            $series = $this->model->orderDesc();
        } else{
        $series = $this->model->getseries();
        }
        return $this->view->response($properties, 200);
    }
    }
    public function ordenseries($params = null) {
        $series = $this->model->ordendesc();
        $this->view->response($series);
    }

    public function getTask($params = null) {
        $id = $params[':ID'];
        $series = $this->model->id($id);
        if ($series)
            $this->view->response($series);
        else 
            $this->view->response("La tarea con el id=$id no existe", 404);
    }

    public function deleteTask($params = null) {
        $id = $params[':ID'];

        $series = $this->model->id($id);
        if ($series) {
            $this->model-> borrarserieid($id);
            $this->view->response($series);
        } else 
            $this->view->response("La tarea con el id=$id no existe", 404);
    }

    public function insertTask($params = null) {
        $series = $this->getData();

        if (empty($series->titulo) || empty($series->genero) || empty($series->descripcion)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->agregoserie($series->titulo, $series->genero, $series->descripcion);
            $series = $this->model->id($id);
            $this->view->response($series, 201);
        }
    

     public function updateTask($params = null) {
        $id = $params[':ID'];
         $data = $this->getData();
                
         $tarea = $this->model->get($id);
         if ($tarea) {
              $this->model->update($id, $data->prioridad);
              $this->view->response("La tarea fue modificada con exito.", 200);
            } else
             $this->view->response("La tarea con el id={$id} no existe", 404);
            }
        
    }



