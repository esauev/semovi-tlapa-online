<?php
namespace App\interfaces;
defined("APPPATH") OR die("Access denied");

interface Navigate {
    public function index();
    public function add();
    public function edit($id);
    public function delete($id);
}