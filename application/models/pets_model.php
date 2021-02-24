<?php

class pets_model extends CI_Model{
    
    public function create($formarray)
    {
        $this->db->insert('pets',$formarray);
        return $this->db->insert_id();
    }

    public function getlist(){
        $query = $this->db->get('pets');

        if($query->num_rows()>0){
             return $query->result_array();
            
        }
        else
        {
            return false;
        }
    }

    public function updatedetails($petdata,$id){
        $this->db->where('id',$id);
        $this->db->update('pets',$petdata);
        echo $this->db->last_query();
        $updated_status = $this->db->affected_rows();
        return $updated_status;
        
    }

    public function getone_model($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $query = $this->db->get('pets');

        if($query->num_rows()>0){
             return $query->result_array();
            
        }
        else
        {
            return false;
        }
        
    }

    public function delete_model($id){
        $this->db->where('id',$id);
        $this->db->delete('pets');
        echo $this->db->last_query();
        $updated_status = $this->db->affected_rows();
        return $updated_status;
    }

    public function owners_model(){
        $this->db->select('owner');
        $query = $this->db->get('pets');

        if($query->num_rows()>0){
             return $query->result_array();
            
        }
        else
        {
            return false;
        }

    }

    public function pofowner($owner){
        $this->db->where('owner',$owner);
        $this->db->select('category');
        $query = $this->db->get('pets');
        if($query->num_rows()>0){
            return $query->result_array(); 
       }
       else
       {
           return false;
       }
    }

    public function oofpets($cat){
        $this->db->where('category',$cat);
        $this->db->select('owner');
        $query = $this->db->get('pets');
        if($query->num_rows()>0){
            return $query->result_array();
       }
       else
       {
           return false;
       }
    }

}
?>