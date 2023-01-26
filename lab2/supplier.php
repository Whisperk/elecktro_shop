<?php include("includes/header.php"); ?>
<?php


$dsn = 'mysql:host=localhost;dbname=elecktro_shop';
$username = 'root';
$goods_id = '';

try{
    // Connect To MySQL Database
    $con = new PDO($dsn,$username,$goods_id);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (Exception $ex) {
    
    echo 'Not Connected '.$ex->getMessage();
    
}

$supplier_id = '';
$company_name = '';
$email = '';
$phone = '';
$goods_id = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['supplier_id'];
    $posts[1] = $_POST['company_name'];
    $posts[2] = $_POST['email'];
    $posts[3] = $_POST['phone'];
    $posts[4] = $_POST['goods_id'];
    
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
        
        $searchStmt = $con->prepare('SELECT * FROM supplier WHERE supplier_id = :supplier_id');
        $searchStmt->execute(array(
            ':supplier_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $supplier_id  = $user[0];
            $company_name = $user[1];
            $email    = $user[2];
            $phone = $user[3];
            $goods_id = $user[4];
        }
        
    }
}

// Insert Data

if(isset($_POST['insert']))
{
    $data = getPosts();
    if(empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]))
    {
        echo 'Enter The User Data To Insert';
    }  else if (!filter_var ($data[2], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {
        
        $insertStmt = $con->prepare('INSERT INTO supplier(company_name,email,phone,goods_id) VALUES(:company_name,:email,:phone,:goods_id)');
        $insertStmt->execute(array(
            ':company_name'  => $data[1],
            ':email'      => $data[2],
            ':phone'  => $data[3],
            ':goods_id'   => $data[4],
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
    }  else if (!filter_var ($data[2], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {
        
        $updateStmt = $con->prepare('UPDATE supplier SET company_name = :company_name, email= : email, phone= : phone, goods_id = : goods_id WHERE supplier_id = :supplier_id');
        $updateStmt->execute(array(
            ':supplier_id '=> $data[0],
            ':company_name'=> $data[1],
            ':email '=> $data[2],
            ':phone '=> $data[3],
            ':goods_id '=> $data[4],
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
        
        $deleteStmt = $con->prepare('DELETE FROM supplier WHERE supplier_id = :supplier_id');
        $deleteStmt->execute(array(
            ':supplier_id'=> $data[0]
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
            <form action="supplier.php" method="POST">
               
                <label for="">supplier_id<br>
                    <input type="text" name='supplier_id' value="<?php echo $supplier_id;?>"><br></p>
                    <label for="">company_name<br>
                        <input type="text" name='company_name' value="<?php echo $company_name;?>"><br></p>
                        <label for="">email<br>
                            <input type="text" name='email' value="<?php echo $email;?>"><br></p>
                            <label for="">phone<br>
                                <input type="text" name='phone' value="<?php echo $phone;?>"><br></p>
                                <label for="">goods_id<br>
                                    <input type="text" name='goods_id' value="<?php echo $goods_id;?>"><br></p>

                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

