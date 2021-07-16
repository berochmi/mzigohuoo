<?php
class ControllersActions extends Model{
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

    public function vPermsByName($data){
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






















    public static function add($data){
        $re = null;
        $success = 0;
        $sql = "replace into controllers_actions
        (controller_name,action_name,
        created_on,edited_on)
        values (:controller_name,:action_name,
        now(),now())
        ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':controller_name'=>$data['controller_name'],
            ':action_name'=>$data['action_name'],
        ]);
      

        $connect_sql = null;
        return $success;
    }

    public function addBo($data){
        $re = null;
        $success = 0;
        $sql = "replace into fuel_requests
        (gen_id,requested_date,requested_amount,request_comments,status,request_log_hrs,request_plc_hrs,
        created_by,created_on,edited_by,edited_on)
        values (:gen_id,:requested_date,:requested_amount,:request_comments,:status,:request_log_hrs,:request_plc_hrs,
        :created_by,now(),:edited_by,now())
        ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':gen_id'=>$data['gen_id'],
            ':requested_date'=>$data['requested_date'],
            ':requested_amount'=>$data['requested_amount'],
            ':request_comments'=>$data['request_comments'],
            ':status'=>$data['status'],
            ':request_log_hrs'=>$data['request_log_hrs'],
            ':request_plc_hrs'=>$data['request_plc_hrs'],
            ":created_by"=>Tool::cleanInput($data["created_by"]),
            ":edited_by"=>Tool::cleanInput($data["edited_by"])
        ]);
        $success = $prep_sql->rowCount();
        if($success){
            $this->setLastId($connect_sql->lastInsertId());
        }
        $connect_sql = null;
        return $success;
    }


  
    public function vFTByGenIdByStatus($data){
        $re  = null;
        $sql = "select * from v_fuel_requests_fts where gen_id = :gen_id and request_fts_status = :request_fts_status " .$data['order'] .";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":gen_id"=>$data["gen_id"],":request_fts_status"=>$data["request_fts_status"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function vAllFTByStatusPaged($data){
        $re  = null;
        $sql = "select * from v_fuel_requests_fts ";
        $sql .= "where request_fts_status like concat('%',:request_fts_status,'%')  and concat(gen_no,site_id,site_name) like concat('%',:search_term,'%') and 
        requested_date >= :date_from and requested_date <= :date_to ";
        $sql .= $data['order'] ." ";
        $sql .= DB::setLimitSql($data['pg_no'],$data['rows_per_pg']). ";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
        ":request_fts_status"=>Tool::cleanInput($data["request_fts_status"]),
        ":search_term"=>Tool::cleanInput($data["search_term"]),
        ":date_from"=>$data['date_from'],
        ":date_to"=>$data['date_to'],
        ]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function vAllFTByStatusPagedCount($data){
        $re  = null;
        $sql = "select count(*) as no_of from v_fuel_requests_fts ";
        $sql .= "where request_fts_status like concat('%',:request_fts_status,'%')  and concat(gen_no,site_id,site_name) like concat('%',:search_term,'%') and 
        requested_date >= :date_from and requested_date <= :date_to ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
            ":request_fts_status"=>Tool::cleanInput($data["request_fts_status"]),
            ":search_term"=>Tool::cleanInput($data["search_term"]),
            ":date_from"=>$data['date_from'],
            ":date_to"=>$data['date_to'],
            ]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re[0]['no_of'];
    }


    public function vAllByStatusPaged($data){
        $re  = null;
        $sql = "select * from v_fuel_tts ";
        $sql .= "where status like concat('%',:status,'%')  and concat(gen_no,site_id,site_name,order_no) like concat('%',:search_term,'%') ";
        $sql .= $data['order'] ." ";
        $sql .= DB::setLimitSql($data['pg_no'],$data['rows_per_pg']). ";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":status"=>Tool::cleanInput($data["status"]),":search_term"=>Tool::cleanInput($data["search_term"])]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function vAllByStatusPagedCount($data){
        $re  = null;
        $sql = "select count(*) as no_of from v_fuel_tts ";
        $sql .= "where status like concat('%',:status,'%')  and concat(gen_no,site_id,site_name,order_no) like concat('%',:search_term,'%') ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":status"=>Tool::cleanInput($data["status"]),":search_term"=>Tool::cleanInput($data["search_term"])]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re[0]['no_of'];
    }

    public function vOneFTById($data){
        $re  = null;
        $sql = "select * from v_fuel_requests_fts where fuel_requests_fts_id = :fuel_requests_fts_id ;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":fuel_requests_fts_id"=>$data["fuel_requests_fts_id"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    
    public function vOneById($data){
        $re  = null;
        $sql = "select * from v_fuel_tts where tt_id = :tt_id ;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":tt_id"=>$data["tt_id"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function updateStatus($data){
        $re = null;
        $success = 0;
        $sql = "update fuel_tts ";
        $sql .= "set status = :status,
        edited_by = :edited_by,edited_on = now() ";
        $sql .= " where id = :tt_id;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':status'=>$data['status'],
        ':edited_by'=>$data['edited_by'],
        ':tt_id'=>$data['tt_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function updateFTFeedbackStatus($data){
        $re = null;
        $success = 0;
        $sql = "update fuel_requests_fts ";
        $sql .= "set request_fts_status = :request_fts_status,bo_fb_by = :bo_fb_by,bo_fb = :bo_fb,
        edited_by = :edited_by,edited_on = now() ";
        $sql .= " where c0d = :fuel_requests_fts_id;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':request_fts_status'=>$data['request_fts_status'],
        ':bo_fb_by'=>$data['bo_fb_by'],
        ':bo_fb'=>$data['bo_fb'],
        ':edited_by'=>$data['edited_by'],
        ':fuel_requests_fts_id'=>$data['fuel_requests_fts_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function updateAllFTStatusByDateByGenId($data){
        $re = null;
        $success = 0;
        $sql = "update fuel_requests_fts ";
        $sql .= "set request_fts_status = :request_fts_status,
        edited_by = :edited_by,edited_on = now() ";
        $sql .= " where requested_date <= :requested_date and gen_id = :gen_id;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':request_fts_status'=>$data['request_fts_status'],
        ':edited_by'=>$data['edited_by'],
        ':requested_date'=>$data['requested_date'],
        ':gen_id'=>$data['gen_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }



}