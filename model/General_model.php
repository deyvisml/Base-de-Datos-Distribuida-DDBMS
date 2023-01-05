<?php
	
	class Clase_x
	{
		// table fields
		public $id;
		public $campo1;
		public $campo2;
		public $campo3;

		// message string
		public $id_msg;
		public $campo1_msg;
		public $campo2_msg;
		public $campo3_msg;

		// constructor set default value
		function __construct()
		{
			$id=0;$category=$name="";
			$id_msg=$category_msg=$name_msg="";
		}
	}

	class General_model
	{
		// set database config for mysql
		function __construct($consetup)
		{
			$this->host = $consetup->host;
			$this->user = $consetup->user;
			$this->pass =  $consetup->pass;
			$this->db = $consetup->db;            					
		}
		// open mysql data base
		public function open_db()
		{
			$this->condb=new mysqli($this->host, $this->user, $this->pass, $this->db);
			if ($this->condb->connect_error) 
			{
    			die("Erron in connection: " . $this->condb->connect_error);
			}
		}
		// close database
		public function close_db()
		{
			$this->condb->close();
		}	

		// insert record
		public function insertRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("INSERT INTO movies (id, title, genres, release_date) VALUES (?, ?, ?, ?)");
				$query->bind_param("ssss", $obj->id, $obj->campo1, $obj->campo2, $obj->campo3);
				$query->execute();
				$res= $query->get_result();
				$last_id = $this->condb->insert_id;

				$query->close();
				$this->close_db();

				return $last_id;
			}
			catch (Exception $e) 
			{
				$this->close_db();	
            	throw $e;
        	}
		}

        //update record
		public function updateRecord($obj)
		{
			try
			{	
				$this->open_db();
				$query=$this->condb->prepare("UPDATE movies SET title = ?, genres = ?, release_date = ? WHERE id=?");
				$query->bind_param("ssss", $obj->campo1, $obj->campo2, $obj->campo3, $obj->id);
				$query->execute();
				$res=$query->get_result();						
				$query->close();
				$this->close_db();
				return true;
			}
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}
        }
         // delete record
		public function deleteRecord($id)
		{	
			try{
				$this->open_db();
				$query=$this->condb->prepare("DELETE FROM movies WHERE id=?");
				$query->bind_param("s",$id);
				$query->execute();
				$res=$query->get_result();
				$query->close();
				$this->close_db();
				return true;	
			}
			catch (Exception $e) 
			{
            	$this->close_db();
            	throw $e;
        	}		
        }   
        // select record     
		public function selectRecord($id)
		{
			try
			{
                $this->open_db();
                if($id>0)
				{	
					$query=$this->condb->prepare("SELECT * FROM movies WHERE id=? ORDER BY title ASC LIMIT 20 ");
					$query->bind_param("s",$id);
				}
                else
                {
					$query=$this->condb->prepare("SELECT * FROM movies ORDER BY title ASC LIMIT 20 ");	
				}		
				
				$query->execute();
				$res=$query->get_result();	
				$query->close();				
				$this->close_db();                
                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
		}

		public function search($key_word)
		{
			try
			{
                $this->open_db();

				$key_word = '%'.$key_word.'%';

				$query=$this->condb->prepare("SELECT * FROM movies WHERE title LIKE ?");
				$query->bind_param("s",$key_word);		
				
				$query->execute();
				$res = $query->get_result();	
				$query->close();				
				$this->close_db();    

                return $res;
			}
			catch(Exception $e)
			{
				$this->close_db();
				throw $e; 	
			}
		}
	}

?>