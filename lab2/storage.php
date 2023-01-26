<?php include("includes/header.php"); ?>
<?php


$dsn = 'mysql:host=localhost;dbname=elecktro_shop';
$usergoods_id = 'root';
$password = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$usergoods_id,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}

$storage_id = '';
$goods_id = '';
$amount = '';
$manager_id  = '';


function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['storage_id'];
    $posts[1] = $_POST['goods_id'];
    $posts[2] = $_POST['amount'];
    $posts[3] = $_POST['manager_id'];

    
    return $posts;
}

//Search And Display Data 

if(isset($_POST['search']))
{
    $data = getPosts();
    if(empty($data[0]))
    {
        echo 'Enter The User Id To Search';
    }  else {
        
        $searchStmt = $con->prepare('SELECT * FROM storage WHERE storage_id = :storage_id');
        $searchStmt->execute(array(
            ':storage_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $storage_id  = $user[0];
            $goods_id = $user[1];
            $amount    = $user[2];
            $manager_id  = $user[3];
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO storage(goods_id,amount,manager_id ) VALUES(:goods_id,:amount,:manager_id )');
        $insertStmt->execute(array(
            ':goods_id'  => $data[1],
            ':amount'      => $data[2],
            ':manager_id'  => $data[3],

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
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]))
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE storage SET goods_id = :goods_id, amount= : amount, manager_id = : manager_id  WHERE storage_id = :storage_id');
        $updateStmt->execute(array(
            ':storage_id'=> $data[0],
            ':goods_id'=> $data[1],
            ':amount'=> $data[2],
            ':manager_id '=> $data[3],

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
        
        $deleteStmt = $con->prepare('DELETE FROM storage WHERE storage_id = :storage_id');
        $deleteStmt->execute(array(
            ':storage_id'=> $data[0]
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
            <form action="storage.php" method="POST">
               
                <label for="">storage_id<br>
                    <input type="text" name='storage_id' value="<?php echo $storage_id;?>"><br></p>
                    <label for="">goods_id<br>
                        <input type="text" name='goods_id' value="<?php echo $goods_id;?>"><br></p>
                        <label for="">amount<br>
                            <input type="text" name='amount' value="<?php echo $amount;?>"><br></p>
                            <label for="">manager_id <br>
                                <input type="text" name='manager_id' value="<?php echo $manager_id ;?>"><br></p>


                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

