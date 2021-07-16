<?php
class UserGroups extends Model{
    public function __construct()
    {
        parent::__construct();
    }

    private $last_id;
    public function setLastId($last_id){
        $this->last_id = $last_id;
    }
    public function getLastId(){
        return $this->last_id;
    }

    public static function vPermsByName($data){
        $re  = null;
        $sql = "select * from v_user_groups_perms where user_group_name = :user_group_name " .$data['order'] .";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":user_group_name"=>$data["user_group_name"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public static function vAll($data){
        $re  = null;
        $sql = "select * from user_groups ";
        $sql .= $data['order'] ." ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute();
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }
}