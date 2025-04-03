<?php
include 'db.php';

class Crud {
    private $pdo;
    function __construct($pdo) {
        $this -> pdo = $pdo;
    }
    private function where_like($where = []){

        $where_statement = '';
        // $counter = 0;
        if(count($where) > 0) {
            $where_statement .= "WHERE";
            $counter = 0;

            foreach($where as $column => $value){

                if($counter < count($where) - 1){
    
                    $where_statement .= " $column LIKE '%$value%' OR";
                }
                else{
                    $where_statement .= " $column LIKE '%$value%' ";
                }
                $counter++;
            }
        }
        return $where_statement;
    }

    private function where($where = []){

        $where_statement = "";
        // $counter = 0;
        if(count($where) > 0) {
            $where_statement .= " WHERE ";
            $conditions = [];
            //$counter = 0;

            foreach($where as $column => $value){

                if (is_array($value)) {
                    $flatValues = array_column($value, 'bookid'); // Adjust the key based on how your data is structured
                    $values = implode(',', array_map('intval', $flatValues)); // Convert to integers
                    $conditions[] = "$column IN ($values)";
                }else{
                    //if($counter < count($where) - 1){
                    if (strpos($column, '<=') !== false) {
                        // $where_statement .= " $column = '$value' AND";
                        $conditions[] = "$column '$value'";
                    } else if (strpos($column, '>=') !== false) {
                        // $where_statement .= " $column = '$value' AND";
                        $conditions[] = "$column '$value'";
                    }
                    else{
                        // $where_statement .= " $column = '$value' ";
                        $conditions[] = "$column = '$value'";
                    }
                    //$counter++;
                }

                
    
            }
            $where_statement .= implode(' AND ', $conditions);
        }
        return $where_statement;

    }

    private function columns($columns = []){

        // if(count($columns) == 0)  {return "*";}
        // else{ return implode(",", $columns);}
        if (empty($columns)) {
            return "*";
        } else {
            return implode(",", $columns);
        }
    }


    public function select($table, $columns = [], $where =[], $limit, $sort) {
        $columns = $this->columns($columns);
        $whereClause = $this->where($where);
        //$sort = ($sort == 'DESC') ? ' ORDER BY id DESC ' : ' ';
        $sort = ($sort == '') ? ' ORDER BY id DESC  '  : ' ORDER BY ' . $sort . ' ';
        $limitClause = ($limit > 0) ?  "LIMIT $limit" : "" ;

         $sql = "SELECT $columns FROM $table $whereClause $sort $limitClause";
         //echo $sql;
        // die();         
         
         return $this->pdo->query($sql);

    }

    public function search($table, $columns = [], $where =[], $limit) {
        $columns = $this->columns($columns);
        $where_like = $this->where_like($where);
        $limit = ($limit > 0) ? " LIMIT  $limit" : "  " ;

         $sql = "SELECT $columns FROM $table $where_like  $limit";

         return $this->pdo->query($sql);
    }

    public function insert($table, $columns=[],$values=[]){

        $kolonat = implode(",", $columns);
        $vlerat = str_repeat("?, ", count($columns));
        $vlerat = rtrim($vlerat,", ");

        $sql = "INSERT INTO $table ($kolonat) VALUES ($vlerat);";
        echo $sql;
        print_r($sql);
        $query = $this->pdo->prepare($sql);

        return $query->execute($values);

    }

    public function update($table, $columns = [], $values = [], $where = []){
        $where = $this->where($where);
        $kolonat = implode("= ? , ", $columns).  " = ?  " ;
        $sql = "UPDATE $table SET $kolonat $where ";
        echo $sql;
        print_r($sql);
        // die();
        $query = $this->pdo->prepare($sql);
        return $query->execute($values);
    }

    public function delete($table, $column, $value){
        $where_statement = " WHERE $column = ? ";
        $sql = " DELETE FROM $table $where_statement ";
        // print_r($sql);
        // die();
        $query = $this->pdo->prepare($sql);
        return $query->execute([$value]); 

    }


    public function distinctSelect($table, $column){
        $sql = "SELECT DISTINCT ($column) FROM $table "; 
        //echo $sql;
        return $this->pdo->query($sql);       

    }
    

}