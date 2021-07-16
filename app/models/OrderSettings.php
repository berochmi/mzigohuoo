<?php
class OrderSettings extends Model {

    
    public function __construct()
    {
        parent::__construct();
    }


    public function getNo($data){
        $rs  = null;
        $sql = "select * from order_settings
        where  order_type = :order_type;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
        ':order_type'=>$data['order_type']
        ]);
        if($inserted){
            $rs = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $rs;
    }

    public function getNextNo($data){
        $rs  = null;
        $sql = "select next_no from order_settings
        where  order_type = :order_type;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
        ':order_type'=>$data['order_type']
        ]);
        if($inserted){
            $rs = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $rs[0]["next_no"];
    }
    
     public function incrementNextNo($data){
        $re = null;
        $success = 0;
        $sql = "update order_settings set ";
        $sql .= "
        next_no = next_no + 1,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where order_type = :order_type";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':edited_by'=>$data['edited_by'],
        ':order_type'=>$data['order_type']
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }
   

    public function updateNextNo($data){
        $re = null;
        $success = 0;
        $sql = "update order_settings ";
        $sql .= "set next_no = :next_no,edited_by = :edited_by,edited_on = now() ";
        $sql .= " where order_type = :order_type";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':next_no'=>$data['next_no'],
        ':edited_by'=>$data['edited_by'],
        ':order_type'=>$data['order_type']
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function updateLastNoById($data){
        $re = null;
        $success = 0;
        $sql = "update order_settings ";
        $sql .= "set last_no = :last_no,edited_by = :edited_by,edited_on = now() ";
        $sql .= " where c0d = :order_type_id";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':last_no'=>$data['last_no'],
        ':edited_by'=>$data['edited_by'],
        ':order_type_id'=>$data['order_type_id']
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }


    public function updateLastOk($data){
        $re = null;
        $success = 0;
        $sql = "update order_settings ";
        $sql .= "set last_ok = :last_ok,edited_by = :edited_by,edited_on = now() ";
        $sql .= " where order_type = :order_type";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':last_ok'=>$data['last_ok'],
        ':edited_by'=>$data['edited_by'],
        ':order_type'=>$data['order_type']
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function add($data){
        $re = null;
        $success = 0;
        $sql = "insert into products ";
        $sql .= "(name,category,description,selling_price,cost,uom,vat,vat_incl,stock,
        created_by,created_on,edited_by,edited_on,deleted)";
        $sql .= " values (:product_name,:product_category,:description,:selling_price,:cost,:uom,:vat,:vat_incl,:stock,
        :created_by,now(),:edited_by,now(),0)";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':product_name'=>$data['product_name'],
        ':product_category'=>$data['product_category'],
        ':description'=>$data['description'],
        ':selling_price'=>$data['selling_price'],
        ':cost'=>$data['cost'],
        ':uom'=>$data['uom'],
        ':vat'=>$data['vat'],
        ':vat_incl'=>$data['vat_incl'],
        ':stock'=>$data['stock'],
        ':created_by'=>$data['created_by'],
        ':edited_by'=>$data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function all($data){
        $re  = null;
        $sql = "select * from order_settings  " .$data['order'] .";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":deleted"=>$data["deleted"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function allPaged($data){
        $re  = null;
        $sql = "select * from order_settings 
        where order_type like concat('%',:search_term,'%') ";
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
        $sql = "select count(*) as no_of from order_settings ";
        $sql .= "where order_type like concat('%',:search_term,'%') ";
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

    public function vOneById($data){
        $re  = null;
        $sql = "select * from order_settings ";
        $sql .= " where c0d = :order_type_id";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([":order_type_id"=>$data["order_type_id"]]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }



}