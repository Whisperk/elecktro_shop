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

$client_id = '';
$full_name = '';
$email = '';
$phone = '';
$password = '';
$age = '';

function getPosts()
{
    $posts = array();
    
    $posts[0] = $_POST['client_id'];
    $posts[1] = $_POST['full_name'];
    $posts[2] = $_POST['email'];
    $posts[3] = $_POST['phone'];
    $posts[4] = $_POST['password'];
    $posts[5] = $_POST['age'];
    
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

        
        $searchStmt = $con->prepare('SELECT * FROM client WHERE client_id = :client_id');
        $searchStmt->execute(array(
            ':client_id'=> $data[0]
        ));
        
        if($searchStmt)
        {
            $user = $searchStmt->fetch();
            if(empty($user))
            {
                echo 'No Data For This Id';
            }
            
            $client_id  = $user[0];
            $full_name = $user[1];
            $email    = $user[2];
            $phone = $user[3];
            $password = $user[4];
            $age= $user[5];
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
        $data[3] = filter_var($data[3], FILTER_SANITIZE_NUMBER_INT);
        $data[2] = filter_var($data[2], FILTER_SANITIZE_EMAIL);
        $insertStmt = $con->prepare('INSERT INTO client(full_name,email,phone,password,age) VALUES(:full_name,:email,:phone,:password,:age)');
        $insertStmt->execute(array(
            ':full_name'  => $data[1],
            ':email'      => $data[2],
            ':phone'  => $data[3],
            ':password'   => $data[4],
            ':age'  => $data[5],
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
    if(empty($data[0]) || empty($data[1]) || empty($data[2]) || empty($data[3]) || empty($data[4]) || empty($data[5]) )
    {
        echo 'Enter The User Data To Update';
    }  else if (!filter_var ($data[2], FILTER_VALIDATE_EMAIL)) {echo "Будь ласка, повторно введіть електронний
лист!"; } else {
        $data[3] = filter_var($data[3], FILTER_SANITIZE_NUMBER_INT);
        $data[2] = filter_var($data[2], FILTER_SANITIZE_EMAIL);
        $updateStmt = $con->prepare('UPDATE client SET full_name = :full_name, email= : email, phone= : phone, password = : password, age = : age WHERE client_id = :client_id');
        $updateStmt->execute(array(
            ':client_id '=> $data[0],
            ':full_name'=> $data[1],
            ':email '=> $data[2],
            ':phone '=> $data[3],
            ':password '=> $data[4],
            ':age '  => $data[5],
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
        
        $deleteStmt = $con->prepare('DELETE FROM client WHERE client_id = :client_id');
        $deleteStmt->execute(array(
            ':client_id'=> $data[0]
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
            <form action="client.php" method="POST">
               
                <label for="">client_id<br>
                    <input type="text" name='client_id' value="<?php echo $client_id;?>"><br></p>
                    <label for="">full_name<br>
                        <input type="text" name='full_name' value="<?php echo $full_name;?>"><br></p>
                        <label for="">email<br>
                            <input type="text" name='email' value="<?php echo $email;?>"><br></p>
                            <label for="">phone<br>
                                <input type="text" name='phone' value="<?php echo $phone;?>"><br></p>
                                <label for="">password<br>
                                    <input type="text" name='password' value="<?php echo $password;?>"><br></p>
                                    <label for="">age<br>
                                        <input type="text" name='age' value="<?php echo $age;?>"><br><br></p>

                                        
                                        
                                        <input class="bbutton" type= "submit" name="insert" value="Insert">
                                        <input class="bbutton" type="submit" name="update" value="Update">
                                        <input class="bbutton" type="submit" name="delete" value="Delete">
                                        <input class="bbutton" type="submit" name="search" value="Search">

                                    </form>
                        </div>   
                        </div> 
                        <?php include("includes/footer.php"); ?>

