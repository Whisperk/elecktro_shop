<?php include("includes/header.php"); ?>
<?php


$dsn = 'mysql:host=localhost;dbname=elecktro_shop';
$userfull_name = 'root';
$password = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$userfull_name,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}

$seller_id = '';
$full_name = '';
$phone = '';
$email  = '';


function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['seller_id'];
    $posts[1] = $_POST['full_name'];
    $posts[2] = $_POST['phone'];
    $posts[3] = $_POST['email'];

    
    return $posts;
}

//Search And Display Data 

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Id To Search';
    }  else  {
        
        $searchStmt = $con->prepare('SELECT * FROM seller WHERE seller_id = :seller_id');
        $searchStmt->execute(array(
            ':seller_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $seller_id  = $user[0];
            $full_name = $user[1];
            $phone    = $user[2];
            $email  = $user[3];
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
            $data[2] = filter_var($data[2], FILTER_SANITIZE_NUMBER_INT);
        $data[3] = filter_var($data[3], FILTER_SANITIZE_EMAIL);
    if(empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        echo 'Enter The User Data To Insert';
    }  else if (!filter_var ($data[3], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {

        $insertStmt = $con->prepare('INSERT INTO seller(full_name,phone,email ) VALUES(:full_name,:phone,:email )');
        $insertStmt->execute(array(
            ':full_name'  => $data[1],
            ':phone'      => $data[2],
            ':email'  => $data[3],

        ));
        
        if($insertStmt)
        {
            echo 'Data Inserted';
        }
        
    }
}

//Update Data

if(isset($_POST['update']))
{
    $data = getPosts();
    $data[2] = filter_var($data[2], FILTER_SANITIZE_NUMBER_INT);
     $data[3] = filter_var($data[3], FILTER_SANITIZE_EMAIL);
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        echo 'Enter The User Data To Update';
    }  else if (!filter_var ($data[3], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {

        $updateStmt = $con->prepare('UPDATE seller SET full_name = :full_name, phone= : phone, email = : email  WHERE seller_id = :seller_id');
        $updateStmt->execute(array(
            ':seller_id'=> $data[0],
            ':full_name'=> $data[1],
            ':phone'=> $data[2],
            ':email '=> $data[3],

        ));
        
        if($updateStmt)
        {
            echo 'Data Updated';
        }
        
    }
}

// Delete Data

if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User ID To Delete';
    }  else {
        
        $deleteStmt = $con->prepare('DELETE FROM seller WHERE seller_id = :seller_id');
        $deleteStmt->execute(array(
            ':seller_id'=> $data[0]
        ));
        
        if($deleteStmt)
        {
            echo 'User Deleted';
        }
        
    }
}

?>

    <?php include("includes/header.php"); ?>
            <div class="container mlogin">
    <div id="login">
            <form action="seller.php" method="POST">
               
                <label for="">seller_id<br>
                    <input type="text" name='seller_id' value="<?php echo $seller_id;?>"><br></p>
                    <label for="">full_name<br>
                        <input type="text" name='full_name' value="<?php echo $full_name;?>"><br></p>
                        <label for="">phone<br>
                            <input type="text" name='phone' value="<?php echo $phone;?>"><br></p>
                            <label for="">email <br>
                                <input type="text" name='email' value="<?php echo $email ;?>"><br></p>


                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

