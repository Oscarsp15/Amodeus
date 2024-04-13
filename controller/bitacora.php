<?php
    class Bitacora extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->brand = "Bitacora";
            $this->view->cn = mainModel::conectar();
            $this->view->render('bitacora/index');
        }
    }