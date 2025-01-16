<?php
session_start();
error_reporting(0);
class database
{
	protected $_link, $_result, $_numRows, $inserted;
	public $host = 'localhost';
	public $username = 'root';
	public $password = '';
	public $db = 'medicare_db';
	var $var,$query,$row;
	public function __construct()
	{
        $this->_link = mysqli_connect($this->host, $this->username, $this->password) or die(mysqli_error()." Error in Connection.");
        mysqli_select_db($this->_link,$this->db) or die(mysqli_error()." Database is not Connected.");
 
	}	

	public function disconnect()
	{
		mysqli_close($this->_link);
	}
	public function query($sql)
	{
		return $this->_result = mysqli_query($this->_link,$sql);
		$this->_numRows = mysqli_num_rows($this->_result);
	}
	public function numRows()
	{
		$numrow = mysqli_num_rows($this->_result);
		return $numrow;
	}
	public function last_id()
	{
	$last_id = mysqli_insert_id($this->_link);
	return $last_id;
	}
	public function rows()
	{
		$rows = array();
		for ($x = 0; $x < $this->numRows(); $x++)
		{
			$rows[] = mysqli_fetch_array($this->_result);
		}

		return $rows;
	}
		
	public function assocrows()
	{
		$rows = array();
		for ($x = 0; $x < $this->numRows(); $x++)
		{
			$rows[] = mysqli_fetch_assoc($this->_result);
		}

		return $rows;
	}
	
	public function row()
	{

		 $row = mysqli_fetch_array($this->_result);

		return $row;
	}
	public function escape($var1)
	{
		$escape_val = mysqli_real_escape_string($this->_link,$var1);
		return $escape_val;
	}
	public function validate($var1)
	{
     	$var1 = stripslashes($var1);
		$var1 = trim($var1);
		$var1 = str_replace("'"," ",$var1);
		$var1 = mysqli_real_escape_string($this->_link,$var1);
		return $var1;
	}
	public function insert($table,$field,$val)
	{
        $fields = implode(",",$field);
		$vals   = implode("','",$val);
    		date_default_timezone_set('Asia/Kolkata');
			$date=date('Y-m-d H:i:s');
			$created_data = array_combine($field,$val);
			$insertdata = json_encode($created_data);
			$user = $_SESSION['logged_user'];
			$this->query = "INSERT INTO `change_insoftware` (key_value,name_table,action_in,solution_id,updated_by,created_date) VALUES ('$insertdata','$table','insert','1','$user','$date') ";

			$this->query = mysqli_query($this->_link,$this->query);
			
		    $this->query = "INSERT INTO `$table` ($fields) VALUES ('$vals') ";
        
		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{
			die("".mysqli_error());
		}
		else{
		
			return true;
		}
	}

	public function create($newtable,$existtable)
	{

		$this->query = "CREATE TABLE IF NOT EXISTS $newtable LIKE $existtable";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{

				die("" . mysqli_error());

		}
		else{
			$this->query = "INSERT $newtable SELECT * FROM $existtable";
			$this->query = mysqli_query($this->_link,$this->query);
			if(!$this->query) {
				die("" . mysqli_error());
			}
			else{
				return true;
			}
		}

	}

	public function insertsame($table,$f,$v,$con,$conv)
	{
		$field = implode(",",$f);
		$val   = implode(",",$v);

		 $this->query = "insert into $table ($field) select $val from $table where $con = $conv";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{

				die("" . mysqli_error());

		}
		else{

				return true;

		}

	}

	public function insertsameincondition($table,$f,$v,$condition)
	{
		$field = implode(",",$f);
		$val   = implode(",",$v); 
		  $this->query = "insert into $table ($field) select $val from $table where $condition";


		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{

			die("" . mysqli_error());

		}
		else{

			return true;

		}

	}
	public function insertdifferent($newtable,$existtable,$f,$v)
	{
		$field = implode(",",$f);
		$val   = implode(",",$v);

		 $this->query = "insert into $newtable ($field) select $val from $existtable";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{

			die("" . mysqli_error());

		}
		else{

			return true;

		}

	}
	public function insertdifferent_con($newtable,$existtable,$f,$v,$condition)
	{
		$field = implode(",",$f);
		$val   = implode(",",$v);

		$this->query = "insert into $newtable ($field) select $val from $existtable where $condition";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{

			die("" . mysqli_error());

		}
		else{

			return true;

		}

	}
	public function update($table,$field,$where,$val)
	{
		$field = implode(",",$field);
		
		  $this->query = "UPDATE `$table` SET $field WHERE $where='$val' ";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{
			die("".mysqli_error());
		}
		else{
			$temp = explode(",",$field);
			date_default_timezone_set('Asia/Kolkata');
			$date=date('Y-m-d H:i:s');
			//$created_data = array_combine($field,$val);
			//$field = preg_replace("/[^a-zA-Z 0-9]+/", "", $field );
			$FileName = preg_replace("/'/", '', $temp);
			$insertdata = json_encode($FileName);
			$condition ="$where=$val";
			$user = $_SESSION['logged_user'];
			 $this->query = "INSERT INTO `change_insoftware` (key_value,name_table,where_condition,action_in,solution_id,updated_by,created_date) VALUES ('$insertdata','$table','$condition','update','1','$user','$date') ";

			$this->query = mysqli_query($this->_link,$this->query);
			return true;
		}
	}
	public function updatewithoutcondition($table,$field)
	{
		$field = implode(",",$field);
		
		  $this->query = "UPDATE `$table` SET $field";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{
			die("".mysqli_error());
		}
		else{
			$temp = explode(",",$field);
			date_default_timezone_set('Asia/Kolkata');
			$date=date('Y-m-d H:i:s');
			//$created_data = array_combine($field,$val);
			//$field = preg_replace("/[^a-zA-Z 0-9]+/", "", $field );
			$FileName = preg_replace("/'/", '', $temp);
			$insertdata = json_encode($FileName);
			$user = $_SESSION['logged_user'];
			 $this->query = "INSERT INTO `change_insoftware` (key_value,name_table,where_condition,action_in,solution_id,updated_by,created_date) VALUES ('$insertdata','$table','update','1','$user','$date') ";

			$this->query = mysqli_query($this->_link,$this->query);
			return true;
		}
	}

	public function updatecondition($table,$field,$condition)
	{
		$field = implode(",",$field); 
	   $this->query = "UPDATE `$table` SET $field WHERE $condition ";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
		{
			die("".mysqli_error());
		}
		else{
			$temp = explode(",",$field);
			date_default_timezone_set('Asia/Kolkata');
			$date=date('Y-m-d H:i:s');
			//$created_data = array_combine($field,$val);
			//$field = preg_replace("/[^a-zA-Z 0-9]+/", "", $field );
			$FileName = preg_replace("/'/", '', $temp);
			$insertdata = json_encode($FileName);
			$condition = preg_replace("/'/", '', $condition);
			$user = $_SESSION['logged_user'];
			$this->query = "INSERT INTO `change_insoftware` (key_value,name_table,where_condition,action_in,solution_id,updated_by,created_date) VALUES ('$insertdata','$table','$condition','update','1','$user','$date') ";

			$this->query = mysqli_query($this->_link,$this->query);
			return true;
		}
	}

	public function find($table,$field,$val)
	{
		//$view = implode(",",$field);
		$this->query = mysqli_query($this->_link,"SELECT * from $table WHERE $field='$val'  ");
		if(!$this->query)
			die("".mysqli_error());
		$this->row   = mysqli_fetch_array($this->query);
		return $this->row;
	}

	public function delete($table,$field,$val)
	{
		 $user = $_SESSION['logged_user'];

		
	
		//echo "DELETE FROM $table WHERE $field='$val'";
		  $this->query = mysqli_query($this->_link,"DELETE FROM $table WHERE $field='$val' ");
		  
		date_default_timezone_set('Asia/Kolkata');
		$date=date('Y-m-d H:i:s');
		
		$this->query = mysqli_query($this->_link,"SELECT * from $table WHERE $field='$val'  ");
		
		$this->row   = mysqli_fetch_assoc($this->query);
			$key_value =  json_encode($this->row);
		$condition ="$field=$val";

		$this->query = "INSERT INTO `change_insoftware` (name_table,key_value,where_condition,action_in,solution_id,updated_by,created_date) VALUES ('$table','$key_value','$condition','delete','1','$user','$date') ";

		$this->query = mysqli_query($this->_link,$this->query);
		if(!$this->query)
			die("".mysqli_error());
	}

	public function selected($var1,$var2)
	{
		if($var1 == $var2) echo "selected";

	}
	public function random($var)
	{
		//GENRATE CODE
		$random_id = uniqid(rand(),1);

		// REPLACE '.' or '/'
		$random_id = str_replace("/","",$random_id);
		$random_id = str_replace(".","",$random_id);

		//REVERSE THE STRING
		$random_id = strrev($random_id);

		//taken first $Var
		$random_id = substr($random_id,0,$var);

		return $random_id;
	}

}
?>
 