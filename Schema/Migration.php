<?php
namespace NewdichSchema;
use NewdichSchema\Settings;
use NewdichSchema\Platform;
use PDO;
use PDOException;

//NOTE: WHEN PUSHING TO PRODUCTION, COMMENT OUT OR DELETE THE createDB() and createTB() methods

class Migration{
    private $table;
    private $columns = [];
    private $rows = [];
    private $conn;
    private $conndb;

    public function __construct(array $data, $table){
        $this->table = $table;
        foreach ($data as $key => $val) {
            $this->columns[] = $this->cleanColumn($key);
            $this->rows[] = $val;
        }

        include($_SERVER["DOCUMENT_ROOT"]."/Schema/Dealer.php");
        $this->conn = $connnewdich;
        $this->conndb = $connnewdichdb;
    } 

    public function createDB($dbname){
        try{
            $qr ="CREATE DATABASE IF NOT EXISTS $dbname";
            $this->conndb->exec($qr);
            echo "Database $dbname successfully created";
            exit;
        }
        catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }

    public function createTB(){
        try{
            //this method creates a MySQL Database
            $usableColumns = implode(',', $this->columns);
            $usableTable = $this->table;
            $createQuery = "CREATE TABLE IF NOT EXISTS $usableTable($usableColumns);";
            $this->conn->exec($createQuery);
            echo "Table $usableTable was created successfully";
            exit;
        }
        catch(Exception $e){
            echo $e->getMessage();
            exit;
        }
    }



    public function saveUnique($uniqueCol, $uniqueData){
        try{
            //check if the $uniquedata already exists
            $table = $this->table;
            $uniqueCol = $this->cleanColumn($uniqueCol);
            $q = $this->conn->prepare("SELECT $uniqueCol FROM $table WHERE $uniqueCol=:uc");
            $q->bindParam(':uc', $uniqueCol);
            $q->execute();
            if($q->rowCount() < 1){
                //GET THE COLUMN BINDER
                $colBinder = [];
                for($i = 0; $i < count($this->columns); $i++){
                    $colBinder[] = ":".$this->columns[$i];
                }

                $colBinderToStr = implode(',', $colBinder);
                $colsToStr = implode(',', $this->columns);
                $qq = $this->conn->prepare("INSERT INTO $table($colsToStr) VALUES($colBinderToStr)");
                //loop it
                for($x = 0; $x < count($colBinder); $x++){
                    $bindo = $colBinder[$x];
                    $bindoVal = $this->rows[$x];
                    $qq->bindParam($bindo, $bindoVal);
                }
                //execute
                $qq->execute();
                if($qq){
                    return json_encode(array("status"=>"success", "response"=>"saved successfully"), JSON_PRETTY_PRINT);
                }
                else{
                    return json_encode(array("status"=>"failed", "response"=>"failed to save"), JSON_PRETTY_PRINT);
                }
            }
            else{
                return json_encode(array("status"=>"success", "response"=>"saved successfully"), JSON_PRETTY_PRINT);
            }
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }



    public function save(){
        try{
            //get columns and rows
            $colsToStr = implode(',', $this->columns);
            $rowsToStr = implode(',', $this->rows);
            //make columns bindable
            $colsBindable = [];
            for($i=0; $i < count($this->columns); $i++){
                $colsBindable[] =":".$this->columns[$i];
            }
            //bindable columns to string
            $colsBindableToStr = implode(',', $colsBindable);
            //get table
            $table = $this->table;
            $q = $this->conn->prepare("INSERT INTO $table($colsToStr) VALUES($colsBindableToStr)");
            for($x=0; $x<count($colsBindable); $x++){
                $eachColsBindable = $colsBindable[$x];
                $eachRow = $this->rows[$x];
                //now bind
                $q->bindParam($eachColsBindable, $eachRow);
            }
            $q->execute();
            if($q){
                return json_encode(array("status"=>"success", "response"=>"successfully saved"), JSON_PRETTY_PRINT);
            }
            else{
                return json_encode(array("status"=>"failed", "response"=>"failed to save"), JSON_PRETTY_PRINT);
            }
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
            exit;
        }
    }



    public function get($offset, $limit){
        try{
            $table = $this->table;
            $columnsToStr = implode(',', $this->columns);
            //form bindable columns e.g :cols
            //form searchable binds e.g cols=:cols
            $colsBind = [];
            $colsBindSearch = [];
            for($i=0; $i<count($this->columns); $i++){
                $colsBind[] =":".$this->columns[$i];
                $colsBindSearch[] = $this->columns[$i]."=:".$this->columns[$i];
            }

            //convert colsBindSearch array to string
            $colsBindSearchToStr = implode(',', $colsBindSearch);

            $offsetUsed;
            $limitUsed;
            if($offset ==='' || $offset ===null || !is_numeric($offset) || !is_numeric($limit) || $limit ==='' || $limit ===null){
                $offsetUsed = 0;
                $limitUsed = 1;
            }
            
            $q = $this->conn->prepare("SELECT * FROM $table WHERE $colsBindSearchToStr ORDER BY :offse LIMIT :lim");
            for($x=0; $x<count($colsBind); $x++){
                $eachBind = $colsBind[$x];
                $eachVal = $this->rows[$x];
                $q->bindParam($eachBind, $eachVal);
            }
            $q->bindParam(':offse', $offsetUsed);
            $q->bindParam(':lim', $limitUsed);
            $q->execute();
            if($q->rowCount() > 0){
                $rq = $q->fetchAll(PDO::FETCH_ASSOC);
                return json_encode(array("status"=>"success", "response"=>$rq), JSON_PRETTY_PRINT);
            }
            else{
                return json_encode(array("status"=>"failed", "response"=>"no data found"), JSON_PRETTY_PRINT);
            }
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }





    public function remove(){
        try{
            $table = $this->table;
            $colsBind = [];
            $colsBindSearch =[];
            for($i=0; $i<count($this->columns); $i++){
                $colsBind[] =":".$this->columns[$i];
                $colsBindSearch[] = $this->columns[$i]."=:".$this->columns[$i];
            }

            $colsBindSearchToStr = implode(',', $colsBindSearch);

            $q = $this->conn->prepare("DELETE FROM $table WHERE $colsBindSearchToStr");
            for($x=0; $x<count($colsBindSearch); $x++){
                $eachBind = $colsBind[$x];
                $eachVal = $this->rows[$i];
                $q->bindParam($eachBind, $eachVal);
            }
            $q->execute();
            if($q){
                return json_encode(array("status"=>"success", "response"=>"deleted successfully"), JSON_PRETTY_PRINT);
            }
            else{
                return json_encode(array("status"=>"failed", "response"=>"failed to delete"), JSON_PRETTY_PRINT);
            }
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }



    public function edit(array $uniqueData){
        try{
            $uniqueCol = [];
            $uniqueVal = [];
            foreach($uniqueData as $col => $val){
                $uniqueCol[] = $col;
                $uniqueVal[] = $val;
            }

            //make unique column bind e.g :col
            //also make bandsearch r.g col=:col
            $uniqueColBind = [];
            $uniqueColBindSearch = [];
            for($y=0; $y<count($uniqueCol); $y++){
                $uniqueColBind[] =":".$uniqueCol[$y];
                $uniqueColBindSearch[] = $uniqueCol[$y]."=:".$uniqueCol[$y];
            }

            $uniqueColBindSearchStr = implode(',', $uniqueColBindSearch);


            $table = $this->table;
            $colsBind = [];
            $colsBindSearch = [];
            for($i=0; $i<count($this->columns); $i++){
                $colsBind[] =":".$this->columns[$i];
                $colsBindSearch[] = $this->columns[$i]."=:".$this->columns[$i];
            }

            $colsBindSearchToStr = implode(',', $colsBindSearch);
            $q = $this->conn->prepare("UPDATE $table SET $colsBindSearchToStr WHERE $uniqueColBindSearchStr");
            for($x=0; $x<count($colsBindSearch); $x++){
                $eachcol = $colsBind[$x];
                $eachVal = $this->rows[$x];
                $q->bindParam($eachcol, $eachVal);
            }

            for($z=0; $z<count($uniqueColBind); $z++){
                $eachUc = $uniqueColBind[$z];
                $eachUv = $uniqueVal[$z];
                $q->bindParam($eachUc, $eachUv);
            }
            $q->execute();
            if($q){
                return json_encode(array("status"=>"success", "response"=>"edited successfully"), JSON_PRETTY_PRINT);
            }
            else{
                return json_encode(array("status"=>"failed", "response"=>"failed to edit"), JSON_PRETTY_PRINT);
            }
        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }




    private function cleanColumn($column){
        try{

        }
        catch(Exception $e){
            return json_encode(array("status"=>"failed", "response"=>$e->getMessage()), JSON_PRETTY_PRINT);
        }
    }
}
?>