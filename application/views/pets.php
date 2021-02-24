<html>
<head>
    <title>Pet Store</title>
    <link rel="stylesheet" href="<?php echo base_url().'assets/css/bootstrap.css'?>">

</head>
<body>
    <div class="container">
    
        <div class="col-md-6">
            <div class="card mt-3">
                <div class="card-header">
                    <span style="font-weight:bold">Pet's Details</span>
                </div>
                <form action="<?php echo base_url().'index.php/pet_con/create'?>" name="petdetails" id="petdetails" method="post">
                    <div class="card-body">
                        <p class="card-text">All sections are mandatory</p>

                        <div class="form-group"> 
                            <label for="name"><span style="font-weight:bold">Owner</span></label>
                            <input type="text" name="owner" id="owner" value="" class="form-control" placeholder="Owner">
                            <p><?php echo form_error(field:'owner');?></p>

                        </div>
                        <br>
                        <div class="form-group">
                            <label for="name"><span style="font-weight:bold">Category</span></label>
                            <input type="text" name="category" id="category" value="" class="form-control" placeholder="Category">
                            <p><?php echo form_error(field:'category');?></p>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="name"><span style="font-weight:bold">Breed</span></label>
                            <input type="text" name="breed" id="breed" value="" class="form-control" placeholder="Breed">
                            <p><?php echo form_error(field:'breed');?></p>

                        </div><br>
                        <div class="form-group"> 
                            <label for="name"><span style="font-weight:bold">Age</span></label>
                            <input type="number" name="age" id="age" value="" class="form-control" placeholder="Age">
                            <p><?php echo form_error(field:'age');?></p>

                        </div>
                        <br>

                        <div class="form-group"> 
                            <label for="name"><span style="font-weight:bold">Status</span></label>
                            <input type="text" name="status" id="status" value="" class="form-control" placeholder="Status">
                            <p><?php echo form_error(field:'status');?></p>

                        </div>
                        <br>
                       
                        <div class="form-group">
                            <button class="btn btn-block btn-primary">SUBMIT</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>