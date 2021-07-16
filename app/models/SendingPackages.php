<?php
class SendingPackages extends Model
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

    public function addSendingPackage($data)
    {
        $success = 0;
        $sql = "replace into sending_packages ";
        $sql .= "(
        city_from,
        city_to,
        from_branch_id,
        to_branch_id,
        sender_name,
        sender_contacts,
        package_description,
        package_qty,
        package_amount_paid,
        date_received,
        time_received,
        receiver_name,
        receiver_contacts,
        receipt_no,
        collection_date,
        collection_time,
        sending_package_status,
        created_by,created_on,edited_by,edited_on)";
        $sql .= " values (
        :city_from,
        :city_to,
        :from_branch_id,
        :to_branch_id,
        :sender_name,
        :sender_contacts,
        :package_description,
        :package_qty,
        :package_amount_paid,
        :date_received,
        :time_received,
        :receiver_name,
        :receiver_contacts,
        :receipt_no,
        :collection_date,
        :collection_time,
        :sending_package_status,
        :created_by,now(),:edited_by,now())";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':city_from' => $data['city_from'],
            ':city_to' => $data['city_to'],
            ':from_branch_id' => $data['from_branch_id'],
            ':to_branch_id' => $data['to_branch_id'],
            ':sender_name' => $data['sender_name'],
            ':sender_contacts' => $data['sender_contacts'],
            ':package_description' => $data['package_description'],
            ':package_qty' => $data['package_qty'],
            ':package_amount_paid' => $data['package_amount_paid'],
            ':date_received' => $data['date_received'],
            ':time_received' => $data['time_received'],
            ':receiver_name' => $data['receiver_name'],
            ':receiver_contacts' => $data['receiver_contacts'],
            ':receipt_no' => $data['receipt_no'],
            ':collection_date' => $data['collection_date'],
            ':collection_time' => $data['collection_time'],
            ':sending_package_status' => $data['sending_package_status'],
            ':created_by' => $data['created_by'],
            ':edited_by' => $data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

    public function updateSendingPackageStatus($data)
    {
        $success = 0;
        $sql = "update sending_packages set ";
        $sql .= "
        sending_package_status = :sending_package_status,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where 
        c0d = :sending_package_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sending_package_status' => $data['sending_package_status'],
            ':edited_by' => $data['edited_by'],
            ':sending_package_id' => $data['sending_package_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function updateSendingPackageStatusByReceiptNo($data)
    {
        $success = 0;
        $sql = "update sending_packages set ";
        $sql .= "
        sending_package_status = :sending_package_status,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where 
        receipt_no = :receipt_no ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sending_package_status' => $data['sending_package_status'],
            ':edited_by' => $data['edited_by'],
            ':receipt_no' => $data['receipt_no'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }


    public function allPaged($data)
    {
        $re  = null;
        $sql = "select * from sending_packages ";
        $sql .= " where 
        concat('%',receipt_no,'%') like concat('%',:search_receipt_no,'%') and 
        sender_name like concat('%',:search_sender_name,'%') and 
        receiver_name like concat('%',:search_receiver_name,'%') and 
        date_received >= :date_from and 
        date_received <= :date_to  ";
        $DB = new DB();
        $sql .= $data['order'] . " ";
        $sql .= DB::setLimitSql($data['pg_no'], $data['rows_per_pg']) . ";";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
            ":search_receipt_no" => trim($data["search_receipt_no"]),
            ":search_sender_name" => trim($data["search_sender_name"]),
            ":search_receiver_name" => trim($data["search_receiver_name"]),
            ":date_from" => trim($data["date_from"]),
            ":date_to" => trim($data["date_to"]),
        ]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function allPagedCount($data)
    {
        $re  = null;
        $sql = "select count(*) as no_of from sending_packages ";
        $sql .= " where 
        concat('%',receipt_no,'%') like concat('%',:search_receipt_no,'%') and 
        sender_name like concat('%',:search_sender_name,'%') and 
        receiver_name like concat('%',:search_receiver_name,'%') and 
        date_received >= :date_from and 
        date_received <= :date_to  ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([
            ":search_receipt_no" => trim($data["search_receipt_no"]),
            ":search_sender_name" => trim($data["search_sender_name"]),
            ":search_receiver_name" => trim($data["search_receiver_name"]),
            ":date_from" => trim($data["date_from"]),
            ":date_to" => trim($data["date_to"]),
        ]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re[0]['no_of'];
    }

    public function vOneByPackageId($data)
    {
        $re  = null;
        $sql = "select * from sending_packages
        where c0d = :sending_package_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':sending_package_id' => $data['sending_package_id']]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function vOneByPackageId2($data)
    {
        $re  = null;
        $sql = "select * from v_sending_packages
        where sending_package_id = :sending_package_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':sending_package_id' => $data['sending_package_id']]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function addReceivingPackage($data)
    {
        $success = 0;
        $sql = "replace receiving_packages ";
        $sql .= "(
        sending_package_id,
        received_package_description,
        received_package_qty,
        received_date,
        received_time,
        received_collection_date,
        received_collection_time,
        receiving_packages_status,
        created_by,created_on,edited_by,edited_on)";
        $sql .= " values (
        :sending_package_id,
        :received_package_description,
        :received_package_qty,
        :received_date,
        :received_time,
        :received_collection_date,
        :received_collection_time,
        :receiving_packages_status,
        :created_by,now(),:edited_by,now())";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sending_package_id' => $data['sending_package_id'],
            ':received_package_description' => $data['received_package_description'],
            ':received_package_qty' => $data['received_package_qty'],
            ':received_date' => $data['received_date'],
            ':received_time' => $data['received_time'],
            ':received_collection_date' => $data['received_collection_date'],
            ':received_collection_time' => $data['received_collection_time'],
            ':receiving_packages_status' => $data['receiving_packages_status'],
            ':created_by' => $data['created_by'],
            ':edited_by' => $data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

    public function addReceivingPackage2($data)
    {
        $success = 0;
        $sql = "replace receiving_packages ";
        $sql .= "(
        sending_package_id,
        received_package_description,
        received_package_qty,
        receiving_packages_status,
        created_by,created_on,edited_by,edited_on)";
        $sql .= " values (
        :sending_package_id,
        :received_package_description,
        :received_package_qty,
        :receiving_packages_status,
        :created_by,now(),:edited_by,now())";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sending_package_id' => $data['sending_package_id'],
            ':received_package_description' => $data['received_package_description'],
            ':received_package_qty' => $data['received_package_qty'],
            ':receiving_packages_status' => $data['receiving_packages_status'],
            ':created_by' => $data['created_by'],
            ':edited_by' => $data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

    public function vOneReceivedPackageByPackageId($data)
    {
        $re  = null;
        $sql = "select * from receiving_packages
        where sending_package_id = :sending_package_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':sending_package_id' => $data['sending_package_id']]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function updateReceivedPackageStatus($data)
    {
        $success = 0;
        $sql = "update receiving_packages set ";
        $sql .= "
        receiving_packages_status = :receiving_packages_status,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where 
        sending_package_id = :sending_package_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':receiving_packages_status' => $data['receiving_packages_status'],
            ':edited_by' => $data['edited_by'],
            ':sending_package_id' => $data['sending_package_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function addCollectPackage($data)
    {
        $success = 0;
        $sql = "replace collecting_packages ";
        $sql .= "(
        sending_package_id,
        collected_date,
        collected_time,
        collected_by_name,
        collected_by_contacts,
        collected_by_idno,
        collected_by_id_type,
        created_by,created_on,edited_by,edited_on)";
        $sql .= " values (
        :sending_package_id,
        :collected_date,
        :collected_time,
        :collected_by_name,
        :collected_by_contacts,
        :collected_by_idno,
        :collected_by_id_type,
        :created_by,now(),:edited_by,now())";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sending_package_id' => $data['sending_package_id'],
            ':collected_date' => $data['collected_date'],
            ':collected_time' => $data['collected_time'],
            ':collected_by_name' => $data['collected_by_name'],
            ':collected_by_contacts' => $data['collected_by_contacts'],
            ':collected_by_idno' => $data['collected_by_idno'],
            ':collected_by_id_type' => $data['collected_by_id_type'],
            ':created_by' => $data['created_by'],
            ':edited_by' => $data['edited_by']
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

    public function vOneCollectedPackageByPackageId($data)
    {
        $re  = null;
        $sql = "select * from collecting_packages
        where sending_package_id = :sending_package_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':sending_package_id' => $data['sending_package_id']]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function vOneByReceiptNo($data)
    {
        $re  = null;
        $sql = "select * from v_sending_packages
        where receipt_no = :receipt_no ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':receipt_no' => $data['receipt_no']]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }

    public function vAllInProgress()
    {
        $re  = null;
        $sql = "select * from v_sending_packages
        where 
        sending_package_status = 'DROP OFF' or 
        sending_package_status = 'IN TRANSIT' or 
        sending_package_status = 'ARRIVED' 
         ; ";
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

    public function updateSendingPackageSMSStatus($data)
    {
        $success = 0;
        $sql = "update sending_packages set ";
        $sql .= "
        sms_sent = :sms_sent,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where 
        c0d = :sending_package_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sms_sent' => $data['sms_sent'],
            ':edited_by' => $data['edited_by'],
            ':sending_package_id' => $data['sending_package_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    public function updateReceivingPackageSMSStatus($data)
    {
        $success = 0;
        $sql = "update receiving_packages set ";
        $sql .= "
        sms_sent = :sms_sent,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where 
        sending_package_id = :sending_package_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sms_sent' => $data['sms_sent'],
            ':edited_by' => $data['edited_by'],
            ':sending_package_id' => $data['sending_package_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }

    //updateCollectingPackageSMSStatus
    public function updateCollectingPackageSMSStatus($data)
    {
        $success = 0;
        $sql = "update collecting_packages set ";
        $sql .= "
        sms_sent = :sms_sent,
        edited_by = :edited_by,
        edited_on = now() ";
        $sql .= " where 
        sending_package_id = :sending_package_id ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sms_sent' => $data['sms_sent'],
            ':edited_by' => $data['edited_by'],
            ':sending_package_id' => $data['sending_package_id'],
        ]);
        $success = $prep_sql->rowCount();
        $connect_sql = null;
        return $success;
    }


    public function addQRCodeImage($data)
    {
        $success = 0;
        $sql = "replace qrcode_images ";
        $sql .= "(
        sending_package_id,
        image_name)";
        $sql .= " values (
        :sending_package_id,
        :image_name)";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $execute_sql = $prep_sql->execute([
            ':sending_package_id' => $data['sending_package_id'],
            ':image_name' => $data['image_name'],
        ]);
        $success = $prep_sql->rowCount();
        $this->setLastId($connect_sql->lastInsertId());
        $connect_sql = null;
        return $success;
    }

    public function vOneQRCodeImageBySendingPackageId($data)
    {
        $re  = null;
        $sql = "select * from qrcode_images
        where sending_package_id = :sending_package_id ; ";
        $DB = new DB();
        $connect_sql = $DB->dBCxn();
        $prep_sql = $connect_sql->prepare($sql);
        $inserted = $prep_sql->execute([':sending_package_id' => $data['sending_package_id']]);
        if ($inserted) {
            $re = $prep_sql->fetchAll(PDO::FETCH_ASSOC);
        }
        $connect_sql = null;
        return $re;
    }
}