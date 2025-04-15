<?php

class HomeController {
    public function index() {
        include $_SERVER['DOCUMENT_ROOT'] . '/Swift-Place/views/home/homepage.php';

    }
}