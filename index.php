
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CRUD With Page Reload</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
    <?php 
    //1. DB Connection Open
    $conn = mysqli_connect('localhost','root','','curd_db') or die('Could not connect');

    $msg = $row = '';
    //Check for the incomming student_sbmt_btn data
    if( isset($_GET['student_sbmt_btn']) ){

        // Always filter/Sanitize the incomming
        $name = mysqli_real_escape_string($conn,$_GET['name']);
        $surname = mysqli_real_escape_string($conn,$_GET['surname']);
        $addres = mysqli_real_escape_string($conn,$_GET['addres']);
        $mobileno = mysqli_real_escape_string($conn,$_GET['mobileno']);

        //2. Build the query
        $sql = "INSERT INTO friend_tbl(`name`,`surname`,`addres`,`mobno`) VALUES ('$name','$surname','$addres','$mobileno')";

        //3. Execute the query
        mysqli_query($conn,$sql) or die(mysqli_error($conn));

        //4. Display the results

        $msg =  '<script>swal("Good job!", "Data Insert Successfully!", "success");</script>';
    }

    //Check for the delete data data is comming or not
    if( (isset($_GET['action']) && ( $_GET['action'] == 'delete') ) ){
        //echo 'oko';

        //Always filter/sanitize the incomming data
       echo  $id = (int)mysqli_real_escape_string($conn,$_GET['delid']);
        //   '1' ==> 1
        //Type Cast means change a data type into another data type
        //2. Build the query
        $sql = "DELETE FROM `friend_tbl` WHERE id='$id'"; //Where clause

        //3. Execute the query
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4. Display the results
        $msg =  '<script>
        swal({
            title: "Are you sure?",
            text: "Delete your data successfully!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              swal("Poof! Your imaginary file has been deleted!", {
                icon: "warning",
              });
            } 
          });
          </script>';
    }

    if( (isset($_GET['action']) && ( $_GET['action'] == 'edit') ) ){
        
        //Always filter/Sanitize the incomming data
        $id = (int)mysqli_real_escape_string($conn,$_GET['editid']);
        //2.Build
        $sql = "SELECT * FROM friend_tbl  WHERE id='$id'";

        //3.Execute the query
        $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));

        //mysqli_num_rows(result);
        //Check NOR (Number of Rows)
       //echo  ;
       if(mysqli_num_rows($result) > 0 ){
            //Data Avaiable
            //mysqli_fetch_row(result)
            $row = mysqli_fetch_row($result);
            //echo '<pre>';
            //var_dump($row);
            //echo '</pre>';

       }else{
             //Data Not Avaiable
       }

        //4. Display the results
    }

    if( isset($_GET['student_edit_btn']) ){

        //Always filter/Sanitize the incomming data
        $editid = (int)mysqli_real_escape_string($conn,$_GET['editid']);
        $name = mysqli_real_escape_string($conn,$_GET['name']);
        $surname = mysqli_real_escape_string($conn,$_GET['surname']);
        $addres = mysqli_real_escape_string($conn,$_GET['addres']);
        $mobileno = mysqli_real_escape_string($conn,$_GET['mobileno']);

        //2. Build the query
        /*
         UPDATE table_name
        SET column1 = value1, column2 = value2, ...
        WHERE condition;
         */
        $sql = "UPDATE friend_tbl  SET  name='$name',surname='$surname',addres='$addres',mobno='$mobileno' WHERE id='$editid'";

        //3. Execute the query
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4. Display the results
        $msg = '<script>swal("UpDate!", "You clicked the UpDate button!", "success");</script>';
        
    }
    
?>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table mytable">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Surname</th>
                            <th scope="col">Addres</th>
                            <th scope="col">Mobile NO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>  

        <div class="row">
            <div class="col-6 offset-3">
                <h1 class="text-center mt-5">friend  <?php echo ( isset($_GET['action']) && ($_GET['action']=='edit') ) ? 'Update' :'Registration' ?> </h1>
                <?php 
                    echo $msg;
                ?>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <input type="hidden" name="editid" value="<?php echo is_array($row)? $row[0]:'' ?>" />
                    <div class="mb-3">
                        <label for="name" class="form-label"> Name</label>
                        <input type="text" name="name" value="<?php echo is_array($row)? $row[1]:'' ?>" class="form-control" id="name" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label"> Surname</label>
                        <input type="text" name="surname" value="<?php echo is_array($row)? $row[2]:'' ?>" class="form-control" id="surname" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="addres" class="form-label"> Addres</label>
                        <input type="text" name="addres" value="<?php echo is_array($row)? $row[3]:'' ?>" class="form-control" id="addres" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>
                    <div class="mb-3">
                        <label for="mobileno" class="form-label"> Mobile No</label>
                        <input type="number" name="mobileno" value="<?php echo is_array($row)? $row[4]:'' ?>" class="form-control" id="mobileno" aria-describedby="emailHelp" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>
                    <button type="submit" name="<?php echo ( isset($_GET['action']) && ($_GET['action']=='edit') ) ? 'student_edit_btn' :'student_sbmt_btn' ?>" class="btn btn-primary"><?php echo ( isset($_GET['action']) && ($_GET['action']=='edit') ) ? 'Update' :'Submit' ?></button>
                </form>
            </div>
        </div>
        <div class="container">
            <!-- Content here -->
            <?php 
                //2. Build the query
                $sql = 'SELECT * FROM friend_tbl';
                
                
                //3. Execute the query
                $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                //Check for NOR (Number of Row)
                $nor = mysqli_num_rows($result);
                // If NOR > 0 Data Avaiable

                $row = '';
                if($nor > 0){
                    /**
                     * Associative Array
                     *  Key => Value
                     */
                    
                    while ($row2 = mysqli_fetch_assoc($result)) {
                        //echo '<pre>';
                        //var_dump($row2['id']);
                       // echo '</pre>';
                         $row .= '<tr>
                                            <td>'.$row2['id'].'</td>
                                            <td>'.$row2['name'].'</td>
                                            <td>'.$row2['surname'].'</td>
                                            <td>'.$row2['addres'].'</td>
                                            <td>'.$row2['mobno'].'</td>
                                            <td>
                                                <a href="#" class="btn btn-success btn-sm viewstudent" data-bs-toggle="modal" data-bs-target="#exampleModal">VIEW</a>     
                                                <a href="?action=edit&editid='.$row2['id'].'" class="btn btn-info btn-sm">EDIT</a>    
                                                <a onClick="return confirm(\'Are you sure Delete data\') " href="?action=delete&delid='.$row2['id'].'" class="btn btn-danger btn-sm">DELETE</a>    
                                            </td>
                                        </tr>'; 
                                        //

                    }//End of Looop
                    //print_r($row);   
                }
                

                //4. Display the results
            ?>
            <table class="table mt-5">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Addres</th>
                    <th scope="col">Mobile No</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $row; ?>
                </tbody>
                </table>
        </div>
        
            
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script>
            //Check for page load

            (function(){
                //alert('OKOKOKOKOK');
                $(document).on('click', 'a.viewstudent',function(){
                    console.log( this.closest('tr').querySelector('td:first-child').innerHTML );

                    var id =  this.closest('tr').querySelector('td:first-child').innerHTML ;

                    var name = this.closest('tr').querySelector('td:nth-child(2)').innerHTML ;
                    var surname = this.closest('tr').querySelector('td:nth-child(3)').innerHTML ;
                    var addres = this.closest('tr').querySelector('td:nth-child(4)').innerHTML ;
                    var mobileno = this.closest('tr').querySelector('td:nth-child(5)').innerHTML ;
                    
                   // $('table.mytable').innerHTML = 'id';
                   
                   $('.mytable > tbody > tr > td:nth-child(1)').innerHTML = id;
                    
                    console.log($('.mytable > tbody > tr > td:nth-child(1)').innerHTML);

                   /*  $('table.mytable tbody > tr > td:nth-child(2)').innerHTML = name;
                    $('table.mytable tbody > tr > td:nth-child(3)').innerHTML = surname;
                    $('table.mytable tbody > tr > td:nth-child(4)').innerHTML = addres;
                    $('table.mytable tbody > tr > td:nth-child(5)').innerHTML = mobileno; */
                    

                });
                //var x = $('a.viewstudent').closest('tr').find('td:first-child');
                //console.log(x);
            })(jQuery);
        </script>
    </body>
</html>

<?php 
    //5. DB Connection CLose
    mysqli_close($conn);
?>