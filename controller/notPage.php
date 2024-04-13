<?php
    class NotPage extends Controller{
        function __construct()
        {
           parent::__construct();
           $this->view->render('notPage/index');
        }
    }