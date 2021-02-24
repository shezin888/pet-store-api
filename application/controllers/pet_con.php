<?php

class pet_con extends CI_Controller{

    public $api_key_arr         =   [];

    public function __construct() {
        parent::__construct();
        $this->load->model('pets_model');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: authorization");
        header("Content-Type:application/json");
        $this->api_key_arr      =   ['3577d11f9643f97ec0e0f21eac69f713'];
        $headers = apache_request_headers();
        if(!$headers['api_key'] || !in_array($headers['api_key'],$this->api_key_arr)) {
            print_r(json_encode(['status'=>false,'message'=>"Authentication failed"]));die();
        }
    }

    public function create(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $owner =  $obj->{'owner'}; 
        $category =  $obj->{'category'};
        $breed =  $obj->{'breed'};
        $age =  $obj->{'age'};
        $status =  $obj->{'status'};

        $formarray = array();
        $formarray['owner']= $owner;
        $formarray['category']= $category;
        $formarray['breed']= $breed;
        $formarray['age']= $age;
        $formarray['status']= $status;

        $create = $this->pets_model->create($formarray);
        if($create){
            $formarray['id'] = $create;
            print_r(json_encode($formarray));
            die();
        }    
    }

    public function getall(){
        
        $petlist = $this->pets_model->getlist();
        $response = array();
        $i=0;
        $data = array();
        foreach($petlist as $row) {

            $data[$i]['id'] = $row['id']; 
            $data[$i]['owner'] = $row['owner']; 
            $data[$i]['category'] = $row['category']; 
            $data[$i]['breed'] = $row['breed']; 
            $data[$i]['status'] = $row['status']; 

            $i++;
        }
        $response['status'] = "success";
        $response['petlist'] = $data;
        echo json_encode($response,JSON_PRETTY_PRINT);
        }

    public function update(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $owner =  $obj->{'owner'}; 
        $id =  $obj->{'id'}; 
        $petdata = array('owner'=>$owner);
        $update = $this->pets_model->updatedetails($petdata,$id);
        print_r($update);
        
    }

    public function getone(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $id =  $obj->{'id'}; 
        $response = array();
        $update = $this->pets_model->getone_model($id);
        $response['status'] = "success";
        $response['petdetails'] = $update[0];
        echo json_encode($response,JSON_PRETTY_PRINT);
        die();
    }

    public function delete(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $id =  $obj->{'id'}; 
        $update = $this->pets_model->delete_model($id);
        print_r($update);
    }

    public function owners(){
        $owners = $this->pets_model->owners_model();
        $response = array();
        $data = array();
        $i=0;
        foreach($owners as $row) {

            $data[$i] = $row; 

            $i++;
        }
        $response['status'] = "success";
        $response['ownerdetails'] = $data;
        echo json_encode($response,JSON_PRETTY_PRINT);
        
    }
    
    public function petsofowner(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $owner =  $obj->{'owner'}; 
        $update = $this->pets_model->pofowner($owner);

        $response = array();
        $data = array();
        $i=0;
        foreach($update as $row) {

            $data[$i] = $row; 

            $i++;
        }
        $response['status'] = "success";
        $response['pets_of_owner'] = $data;
        echo json_encode($response,JSON_PRETTY_PRINT);

    }

    public function ownerofpets(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $cat =  $obj->{'category'}; 
        $update = $this->pets_model->oofpets($cat);

        $response = array();
        $data = array();
        $i=0;
        foreach($update as $row) {

            $data[$i] = $row; 

            $i++;
        }
        $response['status'] = "success";
        $response['owner_of_pets'] = $data;
        echo json_encode($response,JSON_PRETTY_PRINT);
    }

   

}

?>