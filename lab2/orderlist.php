<?php include("includes/header.php"); ?>
<?php


$dsn = 'mysql:host=localhost;dbname=elecktro_shop';
$username = 'root';
$seller_id = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$seller_id);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}

$orderlist_id = '';
$client_id = '';
$goods_id = '';
$amount = '';
$seller_id = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['orderlist_id'];
    $posts[1] = $_POST['client_id'];
    $posts[2] = $_POST['goods_id'];
    $posts[3] = $_POST['amount'];
    $posts[4] = $_POST['seller_id'];
    
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
        
        $searchStmt = $con->prepare('SELECT * FROM orderlist WHERE orderlist_id = :orderlist_id');
        $searchStmt->execute(array(
            ':orderlist_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $orderlist_id  = $user[0];
            $client_id = $user[1];
            $goods_id    = $user[2];
            $amount = $user[3];
            $seller_id = $user[4];

        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]))
    {
        echo 'Enter The User Data To Insert';
    }  else {
        
        $insertStmt = $con->prepare('INSERT INTO orderlist(client_id,goods_id,amount,seller_id) VALUES(:client_id,:goods_id,:amount,:seller_id)');
        $insertStmt->execute(array(
            ':client_id'  => $data[1],
            ':goods_id'      => $data[2],
            ':amount'  => $data[3],
            ':seller_id'   => $data[4],

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
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]))
    {
        echo 'Enter The User Data To Update';
    }  else {
        
        $updateStmt = $con->prepare('UPDATE orderlist SET client_id = :client_id, goods_id= : goods_id, amount= : amount, seller_id = : seller_id WHERE orderlist_id = :orderlist_id');
        $updateStmt->execute(array(
            ':orderlist_id '=> $data[0],
            ':client_id'=> $data[1],
            ':goods_id '=> $data[2],
            ':amount '=> $data[3],
            ':seller_id '=> $data[4],

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
        
        $deleteStmt = $con->prepare('DELETE FROM orderlist WHERE orderlist_id = :orderlist_id');
        $deleteStmt->execute(array(
            ':orderlist_id'=> $data[0]
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
            <form action="orderlist.php" method="POST">
               
                <label for="">orderlist_id<br>
                    <input type="text" name='orderlist_id' value="<?php echo $orderlist_id;?>"><br></p>
                    <label for="">client_id<br>
                        <input type="text" name='client_id' value="<?php echo $client_id;?>"><br></p>
                        <label for="">goods_id<br>
                            <input type="text" name='goods_id' value="<?php echo $goods_id;?>"><br></p>
                            <label for="">amount<br>
                                <input type="text" name='amount' value="<?php echo $amount;?>"><br></p>
                                <label for="">seller_id<br>
                                    <input type="text" name='seller_id' value="<?php echo $seller_id;?>"><br></p>


                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

