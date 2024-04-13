<?php
    class Acerca extends Controller{
        function __construct()
        {
            parent::__construct();        
        }
        function render(){
            $this->view->id_nav_active = "acerca-active";
            $this->view->id_collapase_active = "";
            $this->view->brand = "Acerca del Sistema";
            $this->view->render('acerca/index');
        }
    }