<?php
namespace rest_api\api;

use Exception;

class Rest {
    private $dbHandler;
    private $empTable="";

    // Constructor
	public function __construct($dbConnection) {
        $this->dbHandler = $dbConnection;
        $this->empTable="emp";
	}
    
    public function updateEmployee($empData){
        $updateQueryPart="";
        if($empData["id"]) {
            foreach($empData as $key=>$value):
                if($key !== 'id'){
                    if(is_string($key)){
                        if(!empty($empData[$key]))
                            $updateQueryPart.="$key='".$value."',";
                    } else {
                        //not string values
                        if(!empty($empData[$key]))
                            $updateQueryPart.="$key=".$value.",";
                    }
                }
            endforeach;
            //trim last comma
            $updateQueryPart= substr($updateQueryPart,0,-1);
            $empQuery="
                UPDATE ".$this->empTable." 
                SET $updateQueryPart
                WHERE id = ".$empData["id"];
                
            if($this->dbHandler->query($empQuery)->execute()) {
                $messgae = "Employee updated successfully.";
                $status = 1;			
            } else {
                $messgae = "Employee update failed.";
                $status = 0;			
            }
        } else {
            $messgae = "Invalid request.";
            $status = 0;
        }
        $empResponse = array(
            'status' => $status,
            'status_message' => $messgae
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);
    }

    public function deleteEmployee($empId) {		
        if($empId) {			
            $empQuery = "
                DELETE FROM ".$this->empTable." 
                WHERE id = '".$empId."'	ORDER BY id DESC";	
            if($this->dbHandler->query($empQuery)->execute()) {
                $messgae = "Employee delete Successfully.";
                $status = 1;			
            } else {
                $messgae = "Employee delete failed.";
                $status = 0;			
            }		
        } else {
            $messgae = "Invalid request.";
            $status = 0;
        }
        $empResponse = array(
            'status' => $status,
            'status_message' => $messgae
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);	
    }

    public function getEmployee($empId) {
        $sqlQuery = '';
        if($empId) {
            $sqlQuery = "WHERE id = '".$empId."'";
        }
        $empQuery = "
            SELECT id, name, skills, address, age 
            FROM ".$this->empTable." $sqlQuery
            ORDER BY id DESC";
        $data = $this->dbHandler->query($empQuery)->fetchAll();
        // and somewhere later:
        foreach ($data as $empRecord) {
            $empData[] = $empRecord;
        }
        header('Content-Type: application/json');
        echo json_encode($empData);	
    }

    public function insertEmployee($empData){
        $empName=$empData["empName"];
        $empAge=$empData["empAge"];
        $empSkills=$empData["empSkills"];
        $empAddress=$empData["empAddress"];		
        $empDesignation=$empData["empDesignation"];
        $empQuery="
            INSERT INTO ".$this->empTable." 
            SET name='".$empName."', age='".$empAge."', skills='".$empSkills."', address='".$empAddress."', designation='".$empDesignation."'";
            
        
        $query = "INSERT INTO ".$this->empTable." (name,age,skills,address,designation) VALUES (?,?,?,?,?) "; //Prequery
        $stmt = $this->dbHandler->prepare($query);
        
        //bind the values one by one
        $stmt->bindParam(1, $empName);
        $stmt->bindParam(2, $empAge);
        $stmt->bindParam(3, $empSkills);
        $stmt->bindParam(4, $empAddress);
        $stmt->bindParam(5, $empDesignation);

        try {
            $this->dbHandler->beginTransaction();
            $stmt->execute();
            $this->dbHandler->commit();
            $messgae = "Employee created Successfully.";
            $status = 1;
        }catch (\Exception $e){
            $this->dbHandler->rollback();
            //$messgae = $e->getMessage();
            $messgae = "Employee creation failed.";
            $status = 0;
        }

        $empResponse = array(
            'status' => $status,
            'status_message' => $messgae
        );
        header('Content-Type: application/json');
        echo json_encode($empResponse);
    }
}
?>