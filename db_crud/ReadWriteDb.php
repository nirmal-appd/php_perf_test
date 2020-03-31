<?php
    namespace db_crud;
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include('./DB.php');

    class ReadWriteDB {

        private $table;
        private $dbHandler;
        //private $tableCols;

        //Constructor where table name is passed
        public function __construct($dbh,$tableName)
        {
            $this->dbHandler = $dbh;
            $this->table=$tableName.date('YmdHis');
        }

        public function getTable() {
            return $this->table;
        }

        /* public function getTableColumns() {
            return $this->tableCols;
        }

        public function setTableCols($tableColumns) {
            $this->tableCols = $tableColumns;
        } */

        //Create table
        public function createTable(string $tableName) {
            try {
                $sql ="CREATE table $tableName(
                empID BIGINT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                empSapID INT NOT NULL,
                empPreName VARCHAR( 50 ) NOT NULL,
                empFirstName VARCHAR( 250 ) NOT NULL, 
                empLastName VARCHAR( 250 ) NOT NULL,
                empCounty VARCHAR( 100 ) NULL,
                empPostcode INT( 50 ) NULL,
                empCountry VARCHAR( 100 ) NOT NULL,
                empRegDate DATE NOT NULL,
                empStatus TINYINT NOT NULL
                );" ;
                $this->dbHandler->exec($sql);
                print("Created $tableName Table");echo "<br />\n";
            
            } catch(\PDOException $e) {
                echo $e->getMessage();//Remove or change message in production code
            }
        }

        //DROP TABLE
        public function dropTable(string $tableName) {
            try {
                $dropSql ="DROP table $tableName";
                $this->dbHandler->exec($dropSql);
            } catch(\PDOException $e) {
                print_r($e->getMessage());
            }
        }

        //Insert into table
        public function insertIntoTable(string $tableName,array $insertData) {
            
            $query = "INSERT INTO $tableName (empSapID,empPreName,empFirstName,
            empLastName,empCounty,empPostCode,empCountry,empRegDate,empStatus) VALUES "; //Prequery
            $qPart = array_fill(0, count($insertData), "(?,?,?,?,?,?,?,?,?)");
            $query .=  implode(",",$qPart);
            $stmt = $this->dbHandler -> prepare($query); 
            $i = 1;
            
            foreach($insertData as $item) { //bind the values one by one
                $stmt->bindParam($i++, $item[0]);
                $stmt->bindParam($i++, $item[1]);
                $stmt->bindParam($i++, $item[2]);
                $stmt->bindParam($i++, $item[3]);
                $stmt->bindParam($i++, $item[4]);
                $stmt->bindParam($i++, $item[5]);
                $stmt->bindParam($i++, $item[6]);
                $stmt->bindParam($i++, $item[7]);
                $stmt->bindParam($i++, $item[8]);
            }
            try {
                $this->dbHandler->beginTransaction();
                $stmt -> execute();
                $this->dbHandler->commit();
            }catch (\Exception $e){
                $this->dbHandler->rollback();
                print_r($e->getMessage());
            }
        }

        //Read from table
        public function readFromTable(string $tableName, array $cols) {
            $tableCols = implode(',',$cols);
            $data = $this->dbHandler->query("SELECT $tableCols FROM $tableName")->fetchAll();
            // and somewhere later:
            foreach ($data as $row) {
                print_r($row['empID']);echo "<br />\n";
            }
        }

        //Update table
        public function updateTable(string $preferredTable, array $tableColToUpdate, array $colValueToUpdate, array $conditionForUpdate, array $conditionParametersUpdate) {
            if(count($tableColToUpdate) == count($colValueToUpdate)) {
                $updateQuery = "UPDATE $preferredTable SET ";
                for($i=0;$i<count($tableColToUpdate);$i++) {
                    if(is_string($colValueToUpdate[$i])){
                        //string to update
                        $updateQuery .= "$tableColToUpdate[$i]= '".$colValueToUpdate[$i]."', ";
                    } else {
                        //boolean or integer
                        $updateQuery .= "$tableColToUpdate[$i]= $colValueToUpdate[$i],";
                    }
                }
                //remove trailing comma
                $updateQuery = substr($updateQuery, 0, -1);

            }
            //remaining query with where clause
            $updateQuery .= " WHERE ".implode(" AND ", $conditionForUpdate);
            try{
                $this->dbHandler->beginTransaction();
                $this->dbHandler->prepare($updateQuery)->execute($conditionParametersUpdate);
                $this->dbHandler->commit();
            }catch(\PDOException $e){
                $this->dbHandler->rollback();
                print($e->getMessage());
            }
        }

        //Delete Table
        public function deleteTable(string $preferredTable, array $conditionForDelete, array $conditionParametersDelete) {
            $deleteQuery = "DELETE from $preferredTable ";
            if($conditionForDelete){
                if(count($conditionForDelete) > 1) {
                    $deleteQuery .= " WHERE ".implode(" AND ", $conditionForDelete);
                } else {
                    $deleteQuery .= " WHERE ".implode(" ", $conditionForDelete);
                }
            }
            //begin delete operation
            try{
                $this->dbHandler->beginTransaction();
                $this->dbHandler->prepare($deleteQuery)->execute($conditionParametersDelete);
                $this->dbHandler->commit();
            }catch(\PDOException $e){
                $this->dbHandler->rollback();
                print($e->getMessage());
            }
        }
        
    }

    $db = DB::getInstance();
    $conn = $db->getConnection();

    //create object for class
    $classObj1 = new ReadWriteDB($conn,'employees');
    $preferredTable = $classObj1->getTable();
    
    //create table
    $classObj1->createTable($preferredTable);
    echo $preferredTable."<br />\n";
    
    //insert table
    $insertData = [
        [213456,'Mr','John','Doe','Darkwoods County',90123,'US','2020-03-21',1],
        [313452,'Mrs','Jane','Roe','Bay County',20121,'US','2020-03-20',1],
        [125456,'Ms','Jennifer','Aniston','Riverside County',30121,'US','2020-03-12',1]];
    $classObj1->insertIntoTable($preferredTable,$insertData);

    //Read Table
    $tableCols = ['empID','empSapID','empPreName','empFirstName','empLastName','empCounty',
            'empPostcode','empCountry','empRegDate','empStatus'];
    $classObj1->readFromTable($preferredTable, $tableCols);
    
    //Update Table
    $tableColToUpdate = ['empSapID','empStatus'];
    $colValueToUpdate = [234513,0];
    $conditionForUpdate = ['empID = ?','empStatus = ?'];
    $conditionParametersUpdate = [1,1];
    $classObj1->updateTable($preferredTable, $tableColToUpdate, $colValueToUpdate, $conditionForUpdate, $conditionParametersUpdate);
    
    //DELETE FROM TABLE
    $conditionForDelete = ['empID = ?','empStatus = ?'];
    $conditionParametersDelete = [1,0];
    $classObj1->deleteTable($preferredTable, $conditionForDelete, $conditionParametersDelete);

    $classObj1->dropTable($preferredTable);
?>