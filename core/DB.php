<?php

class DB{
    private static $_instance = null;
	private $_query,$_error = false,$_result,$_count = 0,$_last_insert_id = null,$last_id=0;


    public function dBCxn(){
		$pdo = null;
		try{
            $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(Exception $e){
			$_error = $e->getMessage();
			$_pdo = null;
			echo '<h3>Error-111</h3>';
			//echo $e;
		}
		return $pdo;
	}

	public function setLastId($last_id){
        $this->last_id = $last_id;
    }
    public function getLastId(){
        return $this->last_id;
    }


	public function insertUpdate($sql,$arr_info){
		$feedback = ["success"=>0,"last_id"=>0];
        $connect_sql = $this->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute($arr_info);
        if($execute_sql){
			$feedback ["success"] = $prep_sql->rowCount();
			$feedback ["last_id"] = $connect_sql->lastInsertId();
        }
        $connect_sql = null;
        return $feedback;
	}

	public function mySelect($sql,$arr_info){
		$re  = null;
        $connect_sql = $this->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute($arr_info);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;

    }
    
    public static function setLimitSql($pg_no,$rows_per_pg){
        return  $limit_sql = 'limit '.($pg_no-1)*$rows_per_pg.','.$rows_per_pg;
    //return  $limit_sql = "limit (:pg_no-1)*:rows_per_pg,:rows_per_pg";
    }
}