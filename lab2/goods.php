<?php include("includes/header.php"); ?>
<?php


$dsn = 'mysql:host=localhost;dbname=elecktro_shop';
$username = 'root';
$password = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}

$goods_id = '';
$name = '';
$description = '';
$supplier_id = '';


function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['goods_id'];
    $posts[1] = $_POST['name'];
    $posts[2] = $_POST['description'];
    $posts[3] = $_POST['supplier_id'];

    
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
        
        $searchStmt = $con->prepare('SELECT * FROM goods WHERE goods_id = :goods_id');
        $searchStmt->execute(array(
            ':goods_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $goods_id  = $user[0];
            $name = $user[1];
            $description    = $user[2];
            $supplier_id = $user[3];
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
        
        $insertStmt = $con->prepare('INSERT INTO goods(name,description,supplier_id) VALUES(:name,:description,:supplier_id)');
        $insertStmt->execute(array(
            ':name'  => $data[1],
            ':description'      => $data[2],
            ':supplier_id'  => $data[3],

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
        
        $updateStmt = $con->prepare('UPDATE goods SET name = :name, description= : description, supplier_id= : supplier_id WHERE goods_id = :goods_id');
        $updateStmt->execute(array(
            ':goods_id '=> $data[0],
            ':name'=> $data[1],
            ':description '=> $data[2],
            ':supplier_id '=> $data[3],

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
        
        $deleteStmt = $con->prepare('DELETE FROM goods WHERE goods_id = :goods_id');
        $deleteStmt->execute(array(
            ':goods_id'=> $data[0]
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
            <form action="goods.php" method="POST">
               
                <label for="">goods_id<br>
                    <input type="text" name='goods_id' value="<?php echo $goods_id;?>"><br></p>
                    <label for="">name<br>
                        <input type="text" name='name' value="<?php echo $name;?>"><br></p>
                        <label for="">description<br>
                            <input type="text" name='description' value="<?php echo $description;?>"><br></p>
                            <label for="">supplier_id<br>
                                <input type="text" name='supplier_id' value="<?php echo $supplier_id;?>"><br></p>


                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

