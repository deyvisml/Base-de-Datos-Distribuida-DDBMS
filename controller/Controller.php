<?php
    require 'model/General_model.php';
    require_once 'config.php';

    session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();
    
	class Controller 
	{
 		function __construct() 
		{   
            // Tener las servidores de las bases de datos en un arreglo y como clave el ip de la db
            //$this->servidores = ["localhost" => ["localhost", "root", "", "ddbms_movies"]];
            $this->servidores = ["192.168.16.177" => ["192.168.16.177", "root", "", "ddbms_movies"], "192.168.16.10" => ["192.168.16.10", "root", "", "ddbms_movies"]];
            //$this->servidores = ["192.168.16.177" => ["192.168.16.177", "root", "", "ddbms_movies"], "192.168.16.10" => ["192.168.16.10", "root", "", "ddbms_movies"], "192.168.16.34" => ["192.168.16.34", "root", "", "ddbms_movies"]];
            //$this->servidores = ["192.168.168.2" => ["192.168.168.2", "root", "", "ddbms_sample"], "52.67.231.97" => ["52.67.231.97", "sql10537080", "QUbaszvLP8", "sql10537080"]];
            //$this->servidores = ["192.168.30.177" => ["192.168.30.177", "root", "", "ddbms_sample"], "192.168.30.10" => ["192.168.30.10", "root", "", "ddbms_sample"], "52.67.231.97" => ["52.67.231.97", "sql10537080", "QUbaszvLP8", "sql10537080"]];
			
            $this->default_ip_server = array_key_first($this->servidores);

            $this->objs_m = [];

            foreach($this->servidores as $servidor)
            {
                $ip_server = $servidor[0];
                $this->obj_config = new config($servidor[0], $servidor[1], $servidor[2], $servidor[3]);
                $this->objs_m[$ip_server] = new General_model($this->obj_config);
            }
		}

        // mvc handler request
		public function mvcHandler() 
		{
			$act = isset($_GET['act']) ? $_GET['act'] : NULL;
			switch ($act) 
			{
                case 'add' :
					$this->insert();
					break;						
				case 'update':
					$this->update();
					break;				
				case 'delete' :					
					$this -> delete();
					break;
                case 'search' :			
                    $this -> search();
                    break;									
				default:
                    $this->list();
			}
		}		

        // page redirection
		public function pageRedirect($url)
		{
			header('Location:'.$url);
		}

        // check validation
		public function checkValidation($obj_clase_x)
        {
            $noerror=true;
            
            // Validate category        
            if(empty($obj_clase_x->id))
            {
                $obj_clase_x->id_msg = "Field is empty.";
                $noerror=false;
            }
            else
            {
                $obj_clase_x->campo1_msg ="";
            } 

            // Validate category        
            if(empty($obj_clase_x->campo1))
            {
                $obj_clase_x->campo1_msg = "Field is empty.";
                $noerror=false;
            }
            else
            {
                $obj_clase_x->campo1_msg ="";
            }          
            
            // Validate name            
            if(empty($obj_clase_x->campo2))
            {
                $obj_clase_x->campo2_msg = "Field is empty.";
                $noerror=false;     
            }
            else
            {
                $obj_clase_x->campo2_msg ="";
            }

            if(empty($obj_clase_x->campo3))
            {
                $obj_clase_x->campo3_msg = "Field is empty.";
                $noerror=false;     
            }
            else
            {
                $obj_clase_x->campo3_msg ="";
            }

            return $noerror;
        }
        
        public function search()
        {
            try
            {
                if(isset($_POST["btn_search"]) && !empty(trim($_POST["key_word"])))
                { // esto al parecer es para que se carga la informacion de un registro por su id, para que pueda editar en base a esa informacion (interesante)
                    
                    $key_word = trim($_POST["key_word"]);
                    $ip_server = trim($_POST["servidores"]);

                    $time1 = time(); // time in seconds since 1970
                    $result = $this->objs_m[$ip_server]->search($key_word);
                    $time2 = time(); // time in seconds since 1970

                    $tiempo_diferencia = $time2-$time1;

                    include "view/list.php";
                }
                else
                {
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }


        // add new record
		public function insert()
		{
            try
            {
                $obj_clase_x = new Clase_x();

                if (isset($_POST['addbtn'])) 
                {   
                    // read form value
                    $obj_clase_x->id = trim($_POST['id']);
                    $obj_clase_x->campo1 = trim($_POST['campo1']);
                    $obj_clase_x->campo2 = trim($_POST['campo2']);
                    $obj_clase_x->campo3 = trim($_POST['campo3']);

                    //call validation
                    $chk=$this->checkValidation($obj_clase_x);                    
                    if($chk)
                    {   
                        //call insert record
                        foreach($this->objs_m as $obj_m)
                        {
                            $pid = $obj_m->insertRecord($obj_clase_x);
                        }

                        $this->list();

                        /*
                        if($pid>0)
                        {
                            //$this->pageRedirect("view/list.php");   
                            $this->list();
                        }
                        else
                        {
                            echo "Somthing is wrong..., try again.";
                        }*/
                    }
                    else
                    {    
                        $_SESSION['obj_clase_xl0']=serialize($obj_clase_x);//add session obj           
                        $this->pageRedirect("view/insert.php");                
                    }
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        // update record
        public function update()
		{
            try
            {
                $obj_clase_x = new Clase_x();

                if (isset($_POST['updatebtn'])) // en esta parte si se actualiza el registro
                {
                    $obj_clase_x->id = trim($_POST['id']);
                    $obj_clase_x->campo1 = trim($_POST['campo1']);
                    $obj_clase_x->campo2 = trim($_POST['campo2']);
                    $obj_clase_x->campo3 = trim($_POST['campo3']);

                    // check validation  
                    $chk = $this->checkValidation($obj_clase_x);

                    if($chk)
                    {
                        foreach($this->objs_m as $obj_m)
                        {
                            $res = $obj_m->updateRecord($obj_clase_x);
                        }

                        if($res)
                        {		
                            $this->list();                           
                        }
                        else
                        {
                            echo "Somthing is wrong..., try again.";
                        }
                    }
                    else
                    {         
                        $_SESSION['obj_clase_x'] = serialize($obj_clase_x);      
                        $this->pageRedirect("view/update.php");                
                    }
                }
                elseif(isset($_GET["id"]) && !empty(trim($_GET["id"])))
                { // esto al parecer es para que se carga la informacion de un registro por su id, para que pueda editar en base a esa informacion (interesante)
                    $id=$_GET['id'];
                    
                    $result=$this->objs_m[$this->default_ip_server]->selectRecord($id);

                    $row = mysqli_fetch_array($result);  
                    $obj_clase_x = new Clase_x();                  
                    $obj_clase_x->id=$row[0];
                    $obj_clase_x->campo1=$row[1];
                    $obj_clase_x->campo2=$row[2];
                    $obj_clase_x->campo3=$row[3];
                    
                    $_SESSION['obj_clase_x']=serialize($obj_clase_x);

                    $this->pageRedirect('view/update.php');
                }
                else
                {
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        // delete record
        public function delete()
		{
            try
            {
                if (isset($_GET['id'])) 
                {
                    $id=$_GET['id'];

                    //call insert record
                    foreach($this->objs_m as $obj_m)
                    {
                        $res = $obj_m->deleteRecord($id);
                    }

                    if($res)
                    {
                        $this->pageRedirect('index.php');
                    }
                    else{
                        echo "Somthing is wrong..., try again.";
                    }
                }else{
                    echo "Invalid operation.";
                }
            }
            catch (Exception $e) 
            {
                throw $e;
            }
        }

        public function list(){
            $result = $this->objs_m[$this->default_ip_server]->selectRecord(0);
            
            include "view/list.php";                                        
        }
    }
		
	
?>