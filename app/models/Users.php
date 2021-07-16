<?php
 class Users extends Model{
     
    private $_table = "users";
  
    public function __construct()
    {
        parent::__construct();
    }

    private $last_id;
    public function setLastId($last_id)
    {
        $this->last_id = $last_id;
    }
    public function getLastId()
    {
        return $this->last_id;
    }


    public function setPassword($password){
        return password_hash($password,PASSWORD_DEFAULT);
    }

    public function add($data){
        $re = null;
        $success = 0;
        $sql = "insert into users ";
        $sql .= "(staff_id,f_name,l_name,m_name,
        password,username,access_code,user_group_id,
        deleted,created_by,created_on,edited_by,edited_on)";
        $sql .= " values (:staff_id,:fname,:lname,:mname,:password,:username,:access_code,:user_group_id,
        0,:created_by,now(),:edited_by,now())";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':staff_id'=>$data['staff_id'],
        ':fname'=>$data['fname'],
        ':lname'=>$data['lname'],
        ':mname'=>$data['mname'],
        ':password'=>$this->setPassword($data['password']),
        ':username'=>$data['username'],
        ':access_code'=>$data['access_code'],
        ':user_group_id'=>$data['user_group_id'],
        ':created_by'=>$data['created_by'],
        ':edited_by'=>$data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function loginUser($data){
        $re = null;
        $bool = false;
        $sql = "select * from users where username = :username group by password; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":username"=>$data["username"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        if(count($re) == 1){
            if(password_verify($data["password"], $re[0]["password"])){
                $bool = true;
            }
        }
        return $bool;
    }

    public function selectUsername($data){
        $sql = "select * from users where username = :username";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":username"=>$data["username"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

     public function selectUsername2($data){
        $sql = "select * from v_users where username = :username";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":username"=>$data["username"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function isThere($data){
        $re  = null;
        $sql = "select count(*) as no_of from users
        where  username = :username 
        ;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
        ':username'=>trim($data['username'])
        ]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re[0]["no_of"];
    }

    public function isThereDup($data){
        $re  = null;
        $sql = "select count(*) as no_of from users
        where  username = :username and  
        c0d != :user_id
        ;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
        ':username'=>trim($data['username']),
        ':user_id'=>$data['user_id']
        ]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re!=null?$re[0]["no_of"]:0;
    }

    public function vOneById($data){
        $re  = null;
        $sql = "select * from users
        where id = :user_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':user_id'=>$data['user_id']]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function allPaged($data){
        $re  = null;
        $sql = "select * from users ";
        $sql .= " where concat(username,f_name,l_name) like concat('%',:search_term,'%') ";
        $sql .= $data['order'] ." ";

        $sql .= DB::setLimitSql($data['pg_no'],$data['rows_per_pg']). ";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
            ":search_term"=>$data["search_term"]
            ]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function allPagedCount($data){
        $re  = null;
        $sql = "select count(*) as no_of from users ";
        $sql .= "where concat(username,f_name,l_name) like concat('%',:search_term,'%')  ";
        $sql .= $data['order'] ." ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
            ":search_term"=>$data["search_term"]
            ]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re[0]['no_of'];
    }

    public function updatePassword($data){
        $success = 0;
        $sql = "update users set  ";
        $sql .= " password = :password,
        edited_by = :edited_by,edited_on = now() 
        where id = :user_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':password'=>$this->setPassword($data['password']),
        ":user_id"=>$data["user_id"],
        ":edited_by"=>$data["edited_by"]
        
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function updateUser($data){
        $success = 0;
        $sql = "update users set  ";
        $sql .= " f_name = :fname,l_name = :lname, m_name = :mname, username = :username,
        role = :role,staff_id = :staff_id,
        deleted = :deleted,edited_by = :edited_by,edited_on = now() 
        where id = :user_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':fname'=>$data['fname'],
        ':lname'=>$data['lname'],
        ':mname'=>$data['mname'],
        ':username'=>$data['username'],
        ':role'=>$data['role'],
        ':staff_id'=>$data['staff_id'],
        ':deleted'=>$data['deleted'],
        ":user_id"=>$data["user_id"],
        ":edited_by"=>$data["edited_by"]
        
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function vAllByUserGroupName($data){
        $re  = null;
        $sql = "select * from v_users
        where lower(user_group_name) = :user_group_name ";
        $sql .= $data["order"]." ;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':user_group_name'=>$data['user_group_name']]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

     public function vAllUsers($data){
        $re  = null;
        $sql = "select * from v_users ";
        $sql .= $data["order"]." ;";
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

    public function vOneByFnameLname($data){
        $re  = null;
        $sql = "select * from v_users
        where concat(f_name,' ',l_name) = :user_names ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':user_names'=>$data['user_names']]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }
    
 }