<?php


$dsn = 'mysql:host=localhost;dbname=elecktro_shop';
$username = 'root';
$storage_id = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$storage_id);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    $message = 'Not Connected '.$ex->getMessage();
    
}

$manager_id = '';
$full_name = '';
$phone = '';
$email = '';
$storage_id = '';
$supplier_id = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['manager_id'];
    $posts[1] = $_POST['full_name'];
    $posts[2] = $_POST['phone'];
    $posts[3] = $_POST['email'];
    $posts[4] = $_POST['storage_id'];
    $posts[5] = $_POST['supplier_id'];
    
    return $posts;
}

//Search And Display Data 

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $message = 'Enter The User Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT * FROM manager WHERE manager_id = :manager_id');
        $searchStmt->execute(array(
            ':manager_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                $message = 'No Data For This Id';
            }
            else{
            $manager_id  = $user[0];
            $full_name = $user[1];
            $phone    = $user[2];
            $email = $user[3];
            $storage_id = $user[4];
            $supplier_id= $user[5];
        }
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
            $data[2] = filter_var($data[2], FILTER_SANITIZE_NUMBER_INT);
        $data[3] = filter_var($data[3], FILTER_SANITIZE_EMAIL);
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]))
    {
        $message = 'Enter The User Data To Insert';
    }  else if (!filter_var ($data[3], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {
        $insertStmt = $con->prepare('INSERT INTO manager(full_name,phone,email,storage_id,supplier_id) VALUES(:full_name,:phone,:email,:storage_id,:supplier_id)');
        $insertStmt->execute(array(
            ':full_name'  => $data[1],
            ':phone'      => $data[2],
            ':email'  => $data[3],
            ':storage_id'   => $data[4],
            ':supplier_id'  => $data[5],
        ));
        
        if($insertStmt)
        {
            $message = 'Data Inserted';
        }
        
    }
}

//Update Data

if(isset($_POST['update']))
{
    $data = getPosts();
            $data[2] = filter_var($data[2], FILTER_SANITIZE_NUMBER_INT);
        $data[3] = filter_var($data[3], FILTER_SANITIZE_EMAIL);
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) )
    {
        $message = 'Enter The User Data To Update';
    }  else if (!filter_var ($data[3], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {
        
        $updateStmt = $con->prepare('UPDATE manager SET full_name = :full_name, phone= : phone, email= : email, storage_id = : storage_id, supplier_id = : supplier_id WHERE manager_id = :manager_id');
        $updateStmt->execute(array(
            ':manager_id '=> $data[0],
            ':full_name'=> $data[1],
            ':phone '=> $data[2],
            ':email '=> $data[3],
            ':storage_id '=> $data[4],
            ':supplier_id '  => $data[5],
        ));
        
        if($updateStmt)
        {
            $message = 'Data Updated';
        }
        
    }
}

// Delete Data

if(isset($_POST['delete']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        $message = 'Enter The User ID To Delete';
    }  else {
        
        $deleteStmt = $con->prepare('DELETE FROM manager WHERE manager_id = :manager_id');
        $deleteStmt->execute(array(
            ':manager_id'=> $data[0]
        ));
        
        if($deleteStmt)
        {
            $message = 'User Deleted';
        }
        
    }
}

?>
    <?php if (!empty($message)) {echo"<p class='error'>" . "MESSAGE: ". $message . "</p>";} ?>
    <?php include("includes/header.php"); ?>
            <div class="container mlogin">
    <div id="login">
            <form action="manager.php" method="POST">
               
                <label for="">manager_id<br>
                    <input type="text" name='manager_id' value="<?php echo $manager_id;?>"><br></p>
                    <label for="">full_name<br>
                        <input type="text" name='full_name' value="<?php echo $full_name;?>"><br></p>
                        <label for="">phone<br>
                            <input type="text" name='phone' value="<?php echo $phone;?>"><br></p>
                            <label for="">email<br>
                                <input type="text" name='email' value="<?php echo $email;?>"><br></p>
                                <label for="">storage_id<br>
                                    <input type="text" name='storage_id' value="<?php echo  $storage_id;?>"><br></p>
                                    <label for="">supplier_id<br>
                                        <input type="text" name='supplier_id' value="<?php echo  $supplier_id;?>"><br><br></p>

                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

