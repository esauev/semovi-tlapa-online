<?php
namespace Core;
defined("APPPATH") OR die("Access denied");

use \Core\App;
use \PDO;

/**
 * @class Conn
 */
Class Database{

    const MAIL = "esauespinozavillarreal@gmail.com";
    const TEMA = 'ExaTech';
    static $_instance;
    private $_mysqli;
    static $_debug;
    static $_mail;

    private function __construct(){
        $this->conectar();
    }

    private function __clone(){ }

    public static function getInstance($debug = true, $mail = false){
        self::$_debug = $debug;
        self::$_mail = $mail;

        if (!(self::$_instance instanceof self)){
            self::$_instance=new self();
        }
        return self::$_instance;
    }

    private function conectar(){
	    //load from config/config.ini
        $config = App::getConfig();

        try {
            $dataPDODB = "mysql:host=".$config["host"].";port=".$config["port"].";dbname=".$config["database"];
            $this->_mysqli = new PDO($dataPDODB, 
                                        $config["user"] , 
                                        $config["password"],
                                        array(
                                            PDO::ATTR_ERRMODE => true, 
                                            PDO::ERRMODE_EXCEPTION => true, 
                                            // PDO::ATTR_PERSISTENT => true
                                        )
                                    );
        }catch(\PDOException $e){
            self::errorMessage($e);
            die();
        }
    }

    private static function errorMessage($e, $sql='', $params = []){
        if(self::$_debug)
            echo $e->getMessage()."\nSql : $sql \n params :\n".print_r($params,1);
        if(self::$_mail)
            mail(self::MAIL,'error en conexion '.self::TEMA,  $e->getMessage()."\nSql : $sql \n params :\n".print_r($params,1));
    }

    public function insert($sql,$params = ''){

        if($params == '' ){
            try{
		        $this->_mysqli->beginTransaction();
                $stmt = $this->_mysqli->exec($sql);
                $res = $this->_mysqli->lastInsertId();
                $this->_mysqli->commit();
                return $res;
            }catch(\PDOException $e){
		        $this->_mysqli->rollback();
		        self::errorMessage($e, $sql, $params);
                return false;
            }
        }else{
            try{
		        $this->_mysqli->beginTransaction();
                $stmt = $this->_mysqli->prepare($sql);
                $stmt->execute($params);
                $res = $this->_mysqli->lastInsertId();
                $this->_mysqli->commit();
                return $res;
            }catch(\PDOException $e){
		        $this->_mysqli->rollback();
		        self::errorMessage($e, $sql, $params);
                return false;
            }
        }
    }

    public function update($sql,$params = ''){

        if($params == ''){
            try{
		        $this->_mysqli->beginTransaction();
                $stmt = $this->_mysqli->exec($sql);
                $this->_mysqli->commit();
                return $stmt;
            }catch(\PDOException $e){
		        $this->_mysqli->rollback();
		        self::errorMessage($e, $sql, $params);
                return false;
            }
        }else{
            try{
		        $this->_mysqli->beginTransaction();
                $stmt = $this->_mysqli->prepare($sql);
                $stmt->execute($params);
                $this->_mysqli->commit();
                return $stmt->rowCount();
            }catch(\PDOException $e){
		        $this->_mysqli->rollback();
		        self::errorMessage($e, $sql, $params);
                return false;
            }
        }
    }

    public function delete($sql,$params = ''){

        if($params == ''){
            try{
                $this->_mysqli->beginTransaction();
                $stmt = $this->_mysqli->exec($sql);
                $this->_mysqli->commit();
                return $stmt;
            }catch(\PDOException $e){
		        $this->_mysqli->rollback();
		        self::errorMessage($e, $sql, $params);
                return false;
            }
        }else{
            try{
                $this->_mysqli->beginTransaction();
                $stmt = $this->_mysqli->prepare($sql);
                $stmt->execute($params);
                $this->_mysqli->commit();
                return $stmt->rowCount();
            }catch(\PDOException $e){
		        $this->_mysqli->rollback();
		        self::errorMessage($e, $sql, $params);
                return false;
            }
        }
    }

    public function queryOne($sql,$params = ''){

        if($params == ''){
           return $this->anyParams($sql, false);
        }else{
           return $this->withParams($sql, $params, false);
        }
    }

    public function queryAll($sql,$params = ''){

        if($params == ''){
            return $this->anyParams($sql, true);
        }else{
            return $this->withParams($sql, $params, true);
        }
    }

    protected function anyParams($sql, $typeQuery) {
        try{
            $stmt = $this->_mysqli->query($sql);
            return $typeQuery ? $stmt->fetchAll(PDO::FETCH_ASSOC) : array_shift($stmt->fetchAll(PDO::FETCH_ASSOC)); // typeQuery TRUE queryAll(return $stmt->fetchAll()), FALSE queryOne (return array_shift($stmt->fetchAll()))
        }catch(\PDOException $e){
            self::errorMessage($e, $sql);
            return false;
        }
    }

    protected function withParams($sql, $params, $typeQuery) {
        try{
            $stmt = $this->_mysqli->prepare($sql);
            foreach($params AS $values=>$val)
                $stmt->bindParam($values,$val);
            $stmt->execute($params);
            return $typeQuery ? $stmt->fetchAll(PDO::FETCH_ASSOC) : array_shift($stmt->fetchAll(PDO::FETCH_ASSOC)); // typeQuery TRUE queryAll(return $stmt->fetchAll()), FALSE queryOne (return array_shift($stmt->fetchAll()))
        }catch(\PDOException $e){
            self::errorMessage($e, $sql, $params);
            return false;
        }
    }
}
