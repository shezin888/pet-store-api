# PET STORE API 
Made a pet store api which helps the pet to manage all the records of sale. We can perform all the below mentioned tasks by this api:
* Get all pet details
* Get a single pet detail
* Create a new pet entry
* Update an existing entry of a pet
* Delete a pet
* Get pets of an owner
* Get owner of a pet 
* Get list of all the owners

***

## FRAMEWORK AND SOFTWARES:
I've used CodeIgniter framework in PHP, all the codes are in PHP. Server used is XAMPP server and database used is MySQL database. JSON used for posting from postman to CI. Postman is used for API testing and debugging.

***

## STEP-BY-STEP EXPLAINATION:

First of all I've created a database and named it `new` inside that created a table named `pets`. In pets we have five columns i.e, `owner`, `category`, `breed`, `age` and `status`.  
* `owner`-> owner of a pet. Eg:Jacob, Simon etc
* `category`-> category of pet. Eg:cat,dog etc
* `breed`-> breed of pet. Eg:dash,persian etc
* `age`-> age of pet. Eg:1,4,2 etc
* `status`-> pet status. Eg:sold,available,pending.

***

Opening CodeIgniter and in `application/config/autoload.php` setting `libraries` passing `'database'` and `'session'`. 
In `application/config/config.php` setting `base_url`.
In `application/config/database.php` setting `hostname`, `username` and `database`.

## pet_con.php and pets_model.php

Now moving to controllers, created a folder `pet_con.php`. Created a Class `class pet_con extends CI_Controller` inside a constructor is created inside we're passing `pets_model.php`. Required headers are mentioned in the constructor. `api_key` is set to a random `md5` value. If `api_key` doesn't match its returning a `FALSE` statement.<br>
We are defining all the functions here:
* `create()` 
``` php
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
```
This is the create function used to create a new row in db, here in postman we're passing all the values correctly in json format, all those values are `json_decoded` then we're passing all the values into a new array `$formarray` the we pass `$formarray` to `create()` in `pets_model`. Then the returned value is printed.

```php
    public function create($formarray)
    {
        $this->db->insert('pets',$formarray);
        return $this->db->insert_id();
    }
```
### Postman Input:
```json
    {
    "owner":"ravi",
    "category":"bird",
    "breed":"parrot",
    "age":2,
    "status":"sold"
}
```
### Postman Output:
```json
    {
    "owner": "ravi",
    "category": "bird",
    "breed": "parrot",
    "age": 2,
    "status": "sold",
    "id": 11
}
```

Here in `create()` we are inserting all the values in `$formarray` to the database. `So new row created in database successfully`<br><br>

* `getall()`
```php
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
```

Here in `getall()` we are displaying all the pet details. Firstly we're calling `getlist()` in `pets_model.php`. Then passing that returned value to `$petlist`. intializing two arrays `$response` and `$data`. Passing all values in `$petlist` to `$data` by foreach. Adding one more key in `$response` as `status`, also passing everything inside `$data` to `$response`. Finally printing `$response`.

```php
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
```

### Postman Output:
```json
    {
    "status": "success",
    "petlist": [
        {
            "id": "1",
            "owner": "susan",
            "category": "cat",
            "breed": "persian",
            "status": "Sold"
        },
        {
            "id": "3",
            "owner": "ranjith",
            "category": "dog",
            "breed": "pug",
            "status": "sold"
        },
        {
            "id": "4",
            "owner": "omer",
            "category": "birds",
            "breed": "love birds",
            "status": "sold"
        },
        {
            "id": "5",
            "owner": "jacob",
            "category": "dog",
            "breed": "husky",
            "status": "pending"
        },
        {
            "id": "6",
            "owner": "simon",
            "category": "dog",
            "breed": "german sheperd",
            "status": "sold"
        },
        {
            "id": "7",
            "owner": "justin",
            "category": "cat",
            "breed": "persian",
            "status": "pending"
        },
        {
            "id": "8",
            "owner": "saii",
            "category": "dog",
            "breed": "dash",
            "status": "sold"
        },
        {
            "id": "10",
            "owner": "xavi",
            "category": "bird",
            "breed": "diamond dove",
            "status": "sold"
        },
        {
            "id": "11",
            "owner": "ravi",
            "category": "bird",
            "breed": "parrot",
            "status": "sold"
        }
    ]
}
```
Here all the pet details is displayed orderwise. `getall()` working properly.<br><br>

* `getone()`
```php
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
```

We are fetching value from postman, here `id` is only inputted, so we're supposed to show all details of that specific `id`. Here `$response` array is created. Passing `$id` to `getone_model()` then passing the returned value to `$response`. And finally printing `$response`.

```php
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
```
Here in model we're checking `WHERE` `$id` matches we're returning that whole row, if no match then return `FALSE`.

### Postman Input:
```json
    {
    "id":10
}
```
### Postman Output:
```json
    {
    "status": "success",
    "petdetails": {
        "id": "10",
        "owner": "xavi",
        "category": "bird",
        "breed": "diamond dove",
        "age": "1",
        "status": "sold"
    }
}
```
Here `getone()` prints all details of the specific `$id`. So pet details shown successfully.<br><br>

* `update()`
```php
    public function update(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $owner =  $obj->{'owner'}; 
        $id =  $obj->{'id'}; 
        $petdata = array('owner'=>$owner);
        $update = $this->pets_model->updatedetails($petdata,$id);
        print_r($update);
        
    }
```
Here we're fetching new `owner` name and `id` from user and we are updating current `owner` to the new `owner` defined by user. `updatedetails()` in `pets_model.php` is passed new `owner` and `id`.

```php
    public function updatedetails($petdata,$id){
        $this->db->where('id',$id);
        $this->db->update('pets',$petdata);
        echo $this->db->last_query();
        $updated_status = $this->db->affected_rows();
        return $updated_status;
        
    }
```
Here we check condition where `id` matches we set the current `owner` name to new `owner` name.

### Postman Input:
```json
    {
    "id":9,
    "owner":"gabriel"
}
```
### Postman Output:
```sql
    UPDATE `pets` SET `owner` = 'gabriel'
WHERE `id` = 9
```
Here `update()` have changed current `owner` name to new `owner` name. So `owner` name changed successfully.<br><br>

* `delete()`
```php
    public function delete(){
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        $id =  $obj->{'id'}; 
        $update = $this->pets_model->delete_model($id);
        print_r($update);
    }
```
Here we're suppose to delete a row by the `id` given by user. First we fetch that `id` given by user. passed to `delete_model()` and then return value is printed.

```php
    public function delete_model($id){
        $this->db->where('id',$id);
        $this->db->delete('pets');
        echo $this->db->last_query();
        $updated_status = $this->db->affected_rows();
        return $updated_status;
    }
```
Here we're checking for `id` if `id` matches then that row is deleted. 

### Postman Input:
```json
    {
    "id":9
}
```
### Postman Output:
```sql
    DELETE FROM `pets`
WHERE `id` = 9
```
Here where `id` equal to 9 that row is deleted. Deletion performed successfully.<br><br>

* `petsofowner()`
```php
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
```
We're suppose to get the `pets` of a specific `owner`, so first we fetch the `owner` name inputted in postman. Then passing that value to `pofowner()` in `pets_model.php`. new array `$response` and `$data` created, returned value is passed to `$data`. adding `status` key to `$response` and after passing `$data` to `$response`.   `$reponse` is printed.

```php
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
```
Here we're checking for `owner`, if `owner` matches then that pet i.e, `category` is returned, else it return `FALSE`

### Postman Input:
```json
    {
    "owner":"omer"
}
```
### Postman Output:
```json
    {
    "status": "success",
    "pets_of_owner": [
        {
            "category": "birds"
        }
    ]
}
```
Hence, pets of owner printed successfully.<br><br>

* `ownerofpets()`
```php
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
```
Here we're suppose to print the `owner` of a specific `pet`, firstly we fetch the `category` i.e, pet inputted by user in postman. Pass it to `oofpets()` in `pets_model.php`. New arrays response and `$data` is `$created`. Returned value from `oofpets()` is passed to `$data`. At last `status` key is added to `$response` and values in `$data` is passed to `$response`. Atlast `$response` is printed.

```php
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
```
Here in `oofpets()` we search for pet where `category` matches, then it will return that `owner` of pet if `category` matches. Else it returns `FALSE`.

### Postman Input:
```json
    {
    "category":"cat"
}
```
### Postman Output:
```json
    {
    "status": "success",
    "owner_of_pets": [
        {
            "owner": "susan"
        },
        {
            "owner": "justin"
        }
    ]
}
```
Here `owner` of all the specified pet is shown. `owner` printed successfully.<br><br>

* `owners()`
```php
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
```
Here we need to print all the `owners` in the database. `owners_model()` is called first then the returned value is passed into `$data` in a foreach. Adding one more key in `$response` and passing the values in `$data` to `$response`. Finally printing `$response`.

```php
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
```
Here in `owners_model()` we select all the `owners` in the table `pets`, and return that values.

### Postman Output:
```json
    {
    "status": "success",
    "ownerdetails": [
        {
            "owner": "susan"
        },
        {
            "owner": "ranjith"
        },
        {
            "owner": "omer"
        },
        {
            "owner": "jacob"
        },
        {
            "owner": "simon"
        },
        {
            "owner": "justin"
        },
        {
            "owner": "saii"
        },
        {
            "owner": "xavi"
        }
    ]
}
```
Hence all the `owner` details from table `pets` is printed successfully.