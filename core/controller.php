<?php 
    class Controller{
        function __construct()
        {
            $this->view = new View();
        }
        function loadModel($model){
            $url = 'model/'.$model.'Model.php';
            if(file_exists($url)){
                require $url;
                $modelname = $model.'Model';
                $model = $this->model = new $modelname();
            }
        }
    }