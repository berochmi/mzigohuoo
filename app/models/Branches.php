<?php
class Branches extends Model
{
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

    public function addBranch($data)
    {
        $success = 0;
        $sql = "insert into sp_sites ";
        $sql .= "(
        site_no,
        site_name,
        site_base,
        site_client_id,
        site_physical_address,
        site_poc_name,
        site_poc_contacts,
        created_by,created_on,edited_by,edited_on)";
        $sql .= " values (
        :site_no,
        :site_name,
        :site_base,
        :site_client_id,
        :site_physical_address,
        :site_poc_name,
        :site_poc_contacts,
        :created_by,now(),:edited_by,now())";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
        ':site_no'=>$data['site_no'],
        ':site_name'=>$data['site_name'],
        ':site_base'=>$data['site_base'],
        ':site_client_id'=>$data['site_client_id'],
        ':site_physical_address'=>$data['site_physical_address'],
        ':site_poc_name'=>$data['site_poc_name'],
        ':site_poc_contacts'=>$data['site_poc_contacts'],
        ':created_by'=>$data['created_by'],
        ':edited_by'=>$data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

    public function allBases($data)
    {
        $re  = null;
        $sql = "select * from my_bases ";
        $sql .= $data['order'] ." ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute();
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function vOneByBranchId($data){
        $re  = null;
        $sql = "select * from branches
        where c0d = :branch_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':branch_id'=>$data['branch_id']]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }

    public function vAllByBase($data){
        $re  = null;
        $sql = "select * from branches
        where city = :my_base 
        order by branch_name asc;";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':my_base'=>$data['my_base']]);
        if($inserted){
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null; 
        return $re;
    }
}