<?php
     
    $conn = mysqli_connect('localhost','root','','curd_db') or die('Could not connect');
    $msg = '';


    if( isset($_GET['sbmt_btn']) ){
        $name = mysqli_real_escape_string($conn,$_GET['name']);
        $surname = mysqli_real_escape_string($conn,$_GET['surname']);
        $address = mysqli_real_escape_string($conn,$_GET['address']);
        $mobileno = mysqli_real_escape_string($conn,$_GET['mobileno']);        






    $sql = "INSERT INTO friend_tbl (`name`,`surname`,`addres`,`mobno`) VALUES ('$name','$surname','$address','$mobileno')";

        mysqli_query($conn,$sql) or die(mysqli_error($conn));

        $msg = '<div class="alert alert-primary" role="alert">
                   Your Data insert successfully
                </div>';


    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="row">
        <div class="col-6 offset-3">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
            <?php
             echo $msg;
            
            ?>

                <h1 class="text-center">Friend Data</h1>
                <div class="mb-3">
                    <label for="name" class="form-label">Friend Name</label>
                    <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">Surname</label>
                    <input type="text" name="surname" class="form-control" id="surname" aria-describedby="emailHelp"
                        required>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" name="address" class="form-control" id="address" aria-describedby="emailHelp"
                        required>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3">
                    <label for="mobileno" class="form-label">Mobile No</label>
                    <input type="number" name="mobileno" class="form-control" id="mobileno" aria-describedby="emailHelp"
                        required>
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <button type="submit" name="sbmt_btn" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="container">

    <?php
    $sql ='SELECT * FROM  friend_tbl';

    $result = mysqli_query($conn,$sql) or die(mysqli_error($conn));


     echo $nor = mysqli_num_rows($result);
     $row = '';
    if($nor > 0){
        while ($row2 = mysqli_fetch_assoc($result)){
            $row .= '<tr>
                    <td>'.$row2['id'].'</td>
                    <td>'.$row2['name'].'</td>
                    <td>'.$row2['surname'].'</td>
                    <td>'.$row2['mobno'].'</td>
                    <td>'.$row2['addres'].'</td>
                    <td>
                        <button class="btn btn-success sm">View</button>
                        <button class="btn btn-info sm">Edit</button>
                        <button class="btn btn-danger sm">Delet</button>
                    </td>
            </tr>';

        }

    }
    
    ?>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">Mobail no</th>
                    <th scope="col">Addres</th>
                </tr>
            </thead>
            <tbody>
                <?php echo $row ; ?>
               
            </tbody>
        </table>

    </div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
</body>

</html>
<?php 
    mysqli_close($conn);
?>