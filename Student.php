<?php namespace Model;
    class Student {
        private $fl_pk_student = 0;
        private $fl_enrollment = "";
        private $fl_name_student = "";
        private $fl_last_name_student = "";
        private $fl_gender = 0;
        private $fl_fk_career = 0;


        protected $mysqli;
        protected $stmt;

        public function __construct() {
            $objConn = new Connection();
            $this->mysqli = $objConn->getConnection();
        }
        
        public function Set($att, $value){
            $this->$att = $value;
        }
        
        public function Get($att){
            return $this->$att;
        }

        public function Insert() {
            $query = "CALL `pto_students`('insert', ?, ?, ?, ?, ?, ?);";
            $this->stmt = $this->mysqli->prepare($query);
            if (!$this->stmt) {
                echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            }
            $this->stmt->bind_param(
                    "isssii", 
                    $this->fl_pk_student, 
                    $this->fl_enrollment, 
                    $this->fl_name_student, 
                    $this->fl_last_name_student, 
                    $this->fl_gender, 
                    $this->fl_fk_career
            );
            if (!$this->stmt->execute()) {
                echo "Execute failed: (" . $this->stmt->errno . ") " . $this->stmt->error;
            }else{
                $this->stmt->get_result();                
            }      
            return $this->stmt->affected_rows;
        }
        
        public function Update() {
            $query = "CALL `pto_students`('update', ?, ?, ?, ?, ?, ?);";
            $this->stmt = $this->mysqli->prepare($query);
            if (!$this->stmt) {
                echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            }
            $this->stmt->bind_param(
                    "isssii", 
                    $this->fl_pk_student, 
                    $this->fl_enrollment, 
                    $this->fl_name_student, 
                    $this->fl_last_name_student, 
                    $this->fl_gender, 
                    $this->fl_fk_career
            );
            if (!$this->stmt->execute()) {
                echo "Execute failed: (" . $this->stmt->errno . ") " . $this->stmt->error;
            }else{
                $this->stmt->get_result();                
            }      
            return $this->stmt->affected_rows;
        }
        
        public function Delete($id_row) {
            $query = "CALL `pto_students`('delete', ?, null, null, null, null, null);";
            $this->stmt = $this->mysqli->prepare($query);
            if (!$this->stmt) {
                echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            }
            $this->stmt->bind_param(
                "i", 
                $id_row
            );
            
            if (!$this->stmt->execute()) {
                echo "Execute failed: (" . $this->stmt->errno . ") " . $this->stmt->error;
            }else{
                $this->stmt->get_result(); 
            }     
            
            return $this->stmt->affected_rows;
        }
        
        public function SelectOne($id_row) {
            $row = null;
            $query = "CALL `pto_students`('selectOne', ?, null, null, null, null, null);";
           
            $this->stmt = $this->mysqli->prepare($query);
            if (!$this->stmt) {
                echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            }
            $this->stmt->bind_param(
                "i", 
                $id_row
            );

            if (!$this->stmt->execute()) {
                echo "Execute failed: (" . $this->stmt->errno . ") " . $this->stmt->error;
            }else{
                $result = $this->stmt->get_result();
                $row = $result->fetch_assoc();                
            }      
            return $row;
        }
        
        public function SelectAll() {
            $rows = null;
            $query = "CALL `pto_students`('selectAll', null, null, null, null, null, null);";
            
            $this->stmt = $this->mysqli->prepare($query);
            if (!$this->stmt) {
                echo "Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error;
            }
            
            if (!$this->stmt->execute()) {
                echo "Execute failed: (" . $this->stmt->errno . ") " . $this->stmt->error;
            }else{
                $result = $this->stmt->get_result();
                while ($data = $result->fetch_assoc()){
                    $rows[] = $data;
                }    
//                var_dump($rows);
            }                     
            return $rows;
        }
        
        public function __toString(){
          return "Nombre: $this->fl_name_student $this->fl_last_name_student Matrícula: $this->fl_enrollment";
        }
        
        public function __destruct() {
            $this->mysqli->close();
            if ($this->stmt) {
                $this->stmt->close();
            }            
        }
    }