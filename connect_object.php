<?php

class database
{
  private $hostname;
  private $usern;
  private $pass;
  private $dbname;
  private $connection;

  public function __construct($host, $username, $password, $databasename)
  {
    $this->hostname = $host;
    $this->usern = $username;
    $this->pass = $password;
    $this->dbname = $databasename;
  }

  public function toconnect()
  {
    $this->connection = mysqli_connect($this->hostname, $this->usern, $this->pass, $this->dbname);
    if (!$this->connection) {
      die("connection failed" . mysqli_connect_error());
    }
  }

  public function todisconnect()
  {
    mysqli_close($this->connection);
  }

  public function exequery($query)
  {
    return mysqli_query($this->connection, $query);
  }

  public function insertdata($table, $columns, $rows)
  {
    $c = "`" . implode("`,`", $columns) . "`";
    $v = "'" . implode("', '", $rows) . "'";

    $sql1 = "INSERT INTO $table ($c) VALUES ($v)";
    $res = $this->exequery($sql1);
    if (!$res) {
      die("Error in insertion of data" . mysqli_error($this->connection));
    }
  }

  public function fetchdatatoform($tab1, $col1, $condition1)
  {
    $v1 = implode(",", $col1);
    
    if (!empty($condition1)) {
      $alpha = 0;
      $sql3 = "select $v1 from $tab1 where $condition1";
      $result = $this->exequery($sql3);
      if (mysqli_num_rows($result) > 0) 
      {
        $row = mysqli_fetch_assoc($result);
        return $row;
      } 
      else 
      {
        return $alpha;
      }
    } 
    
    else 
    {
      $sql3 = "select $v1 from $tab1";
      $result = $this->exequery($sql3);
      return $result;
    }
  }

  public function update($tab2, $condition2, $columns, $rows)
  {
    $u = array();
    for ($i = 0; $i < count($columns); $i++) {
      $u[] = "`" . $columns[$i] . "`" . "=" . "'" . $rows[$i] . "'";
    }
    $ustr = implode(",", $u);

    $sql4 = "update $tab2 set $ustr where $condition2";
   
    $res = $this->exequery($sql4);
    if ($res) {
      echo " successful update";
    }
  }

  public function deletedata($tab3, $condition3)
  {
    $sql5 = "delete from $tab3 where $condition3";
    $this->exequery($sql5);
  }
}
