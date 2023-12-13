<?php
namespace App\models;
defined("APPPATH") OR die("Access denied");

use \Core\Database;
use \App\interfaces\Crud;

class Contenedor implements Crud {

	public static function getAll(){
		$mysqli = Database::getInstance();
		$query =<<<sql
		
		sql;
		return $mysqli->queryAll($query);
	}
	
	public static function getById($id){
		$mysqli = Database::getInstance();
		$query =<<<sql
		SELECT * FROM semovitlapa.user WHERE status = 1 AND user_id = :user_id
		sql;
		return $mysqli->queryOne($query, array(':user_id' => $id));
	}
	public static function insert($data){}
	public static function update($data){}
	public static function delete($data){}

	public static function getMenu($profileId) {
		$mysqli = Database::getInstance();
		$query =<<<sql
		SELECT pm.menu_id, m.name, m.path, m.icon FROM profile_menu AS pm
		INNER JOIN menu AS m ON (pm.menu_id=m.menu_id)
		WHERE profile_id = :profile_id AND sub_menu_id = 0
		ORDER BY m.menu_id
		sql;
		return $mysqli->queryAll($query, array(':profile_id' => $profileId));
	}

	public static function getSubMenu($profileId, $menuId) {
		$mysqli = Database::getInstance();
		$query =<<<sql
		SELECT pm.sub_menu_id, sm.name, CONCAT(m.path, sm.path) as path FROM profile_menu AS pm
		INNER JOIN menu AS m ON (pm.menu_id=m.menu_id)
		INNER JOIN sub_menu As sm ON (pm.sub_menu_id=sm.sub_menu_id)
		WHERE profile_id = :profile_id AND sm.menu_id = :menu_id AND pm.sub_menu_id != 0;
		ORDER BY sm.sub_menu_id
		sql;
		return $mysqli->queryAll($query, array(':profile_id' => $profileId, ':menu_id' => $menuId));
	}

}