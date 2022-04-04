<?php

class DB{

     private $pdo;

     private $column = "*";
     private $table;
     private $where;
     private $operator;
     private $order_by;
     private $group_by;
     private $join;
     private $limit;
     private $value;

    function __construct($dsn,$username,$password)
    {
        $this->pdo=new PDO($dsn,$username,$password);
        
    }

    public function get(){
        $query = "select " .$this->column.
                 " from ".
                 $this->table . 
                 $this->where . 
                 $this->operator . 
                 $this->order_by .
                 $this->group_by .
                 $this->join .
                 $this->limit;

                //  $this->group_by  ;
        
        echo $query;
        // echo $this->column;

       $stm = $this->pdo->prepare($query);
        if ($stm->execute())
        {
            $this->result = $stm->fetchAll();
        }
        else
        {

            $this->result = "error";
        }
        return $this;
        }

        public function count($column){
        $query = "select COUNT (" .$column. ")".
                 " from ".
                 $this->table . 
                 $this->where . 
                 $this->operator . 
                 $this->order_by  .
                 $this->group_by  .
                 $this->join.
                 $this->limit;

        
        echo $query;
        // echo $this->column;

       $stm = $this->pdo->prepare($query);
        if ($stm->execute())
        {
            $this->result = $stm->fetchAll();
        }
        else
        {

            $this->result = "error";
        }
        return $this;
        }

        public function insert(){
            $query = "INSERT INTO ".
             $this->table  ." (" .$this->column. ") VALUES (" .$this->value. ")";
                
        
              echo $query;
             // echo $this->column;

       $stm = $this->pdo->prepare($query);
        if ($stm->execute())
        {
            $this->result = $stm->fetchAll();
        }
        else
        {
            $this->result = "error";
        }
        return $this;


    }

        function update(){
        $query = "UPDATE  ".
             $this->table  . 
                 $this->operator .
                 $this->where ;
                
        
        echo $query;
             // echo $this->column;

       $stm = $this->pdo->prepare($query);
        if ($stm->execute())
        {
            $this->result = $stm->fetchAll();
        }
        else
        {
            $this->result = "error";
        }
        return $this;

    }

     public function column(...$arg){
        $this->column = implode(',' ,$arg);
        // echo ($this->column);
        // print_r($arg);
        return $this;
    }

    public function value(...$arg){
        $this->value=array();
        foreach($arg as $value){

        $this->value[] = is_string($value)?"'".$value."'":$value;
    }
        $this->value = implode(',' , $this->value);
        // echo ($this->column);
        // print_r($arg);
        return $this;
    }

    public function table( $table){
        $this->table = $table;
        return $this;
    } 

    public function where($column_name  ,$op, $value){
        $value = is_string($value)?"'".$value."'":$value;

        $this->where = " WHERE ". $column_name ." ".$op." ". $value ;
        return $this;
    }

    // we can use it for WHERE ,AND , OR , WHERE OR , SET
    public function operator($oprator,$column_name,$op,$value){
        $value = is_string($value)?"'".$value."'":$value;
        $this->operator= " ".$oprator." ".$column_name." ".$op." ".$value;
        return $this;

    }

  
    public function orderBy($order,...$arg){
        $this->order_by= " ORDER BY " .implode(',' ,$arg). " ". $order;
        return $this;
    }

        // we can use it for all type of join
    public function join($joinType=NULL , $tableTwo , $FK , $PK){
        $this->join= " ". $joinType ." JOIN " .$tableTwo. " ON " . $FK ." = ". $PK;
        return $this;
    }

    public function groupBy (...$coulmn){
        $this->group_by= " GROUP BY " .implode(',' ,$coulmn) ;
        return $this;
    }

    public function limit ($number){
        $this->limit= " LIMIT ".$number ;
        return $this;
    }

}



$database="categories";
$dsn="mysql:host=localhost;dbname=$database;charset=utf8mb4";
$username="root";
$password="";
$db=new DB($dsn,$username,$password);


// .............................. Test Select ......................

// $db->column("name","description");

// $db->table("history")->get();
// print_r($v);

// $db->table("history")->where("id","=","29" )->orderBy("BGT","name","id")->get();
// $db->table("history")->column("name")->where("id","=","29")->groupBy("country","id")->get();
// $db->table("history")->where("id","=","29")->join("INNER","book","history.name","book.name")->get();
// $db->table("history")->where("id","=",29 )->limit(3)->get();
// $db->table("history")->column("id","name","description" )->value(3 , "Ahmed" , "nnnnn")->insert();
$db->table("history")->operator("SET","name","=","Ahmed" )->where("id" , "=" , 6)->update();

// ?>