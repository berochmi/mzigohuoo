<?php
 class MyDates extends Model{
     
    private $_table = "my_dates";
  
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

    public function add($data){
    
        $success = 0;
        $sql = "replace into my_dates ";
        $sql .= " select FROM_UNIXTIME(UNIX_TIMESTAMP(CONCAT(:end_date,n)),'%Y-%m-%d') as my_date from (
                select (((b4.0 << 1 | b3.0) << 1 | b2.0) << 1 | b1.0) << 1 | b0.0 as n
                        from  (select 0 union all select 1) as b0,
                              (select 0 union all select 1) as b1,
                              (select 0 union all select 1) as b2,
                              (select 0 union all select 1) as b3,
                              (select 0 union all select 1) as b4 ) t
                          
                where n > 0 and n <= day(last_day(:start_date)) ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':end_date'=>$data['end_date'],
        ':start_date'=>$data['start_date'],
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

 
 }
























