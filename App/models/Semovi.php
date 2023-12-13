<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Semovi implements Crud {

	public static function getAll(){
		$mysqli = Database::getInstance();
		$query =<<<sql
sql;
		return $mysqli->queryAll($query);
	}
	
	public static function getById($id){}
	public static function insert($data){}
	public static function update($data){}
	public static function delete($data){}

	public static function getUserPassword($data){
		$mysqli = Database::getInstance();
		$query =<<<SQL
		SELECT * FROM semovitlapa.user WHERE email = :email AND password = MD5(:password) AND status = 1
SQL;
		return $mysqli->queryOne($query, array(':email' => $data->email, ":password" => $data->password));
	}

}