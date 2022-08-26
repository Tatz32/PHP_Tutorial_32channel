<?php 

date_default_timezone_set("Europe/Madrid");

//created data will be changed to array form
$comment_array = array();
$pdo = null;
$stmt = null;
$error_message = array();

//connect to database
try{
    $pdo = new PDO('mysql:host=localhost;dbname=php-youtube', "root", "");
}catch(PDOException $e){
    echo $e->getMessage();
}
//This is triggered when the form is filled
//The if method means that the function happends after the enter key is pushed and the condition will be true
try{
if(!empty($_POST["submitBtn"])){

    //check if you filled your username
    if(empty($_POST["username"])){
        echo "Write your username";
        $error_message["username"] = "Write your username";
    }
    //check if you filled comment
    if(empty($_POST["comment"])){
        echo "Write comment";
        $error_message["comment"] = "Write Comment";
    }
    if(empty($error_message)){
    
    $postDate = date("Y-m-d H:i:s");
    $stmt = $pdo->prepare("INSERT INTO `php-youtube-table` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate);");
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':comment', $_POST['comment'] );
    $stmt->bindParam(':postDate', $postDate);
    $stmt->execute();
    }
}
}
catch(PDOException $e){
    echo $e->getMessage();
}


//get data from database
$sql = "SELECT * FROM `php-youtube-table`";
$comment_array = $pdo->query($sql);
//close database
$pdo = null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Example</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">PHP Example</h1>
    <hr>
    <div class="boardWrapper">
        <section>
            <?php foreach($comment_array as $comment) :?>
            <article>
                <div class="wrapper">
                    <div class="nameArea">
                        <span>
                            name :
                        </span>
                        <p class="username"><?php echo $comment["username"];?></p>
                        <time>:<?php echo $comment["postDate"];?></time>
                    </div>
                    <p class="comment"><?php echo $comment["comment"];?></p>
                </div>
            </article>
            <?php endforeach ;?>
        </section>
        <form class="formWrapper" method="POST">
            <div >
                <input type="submit" value="Submit" name="submitBtn">
                <label for="">Name : </label>
                <input type="text" name="username">
            </div>
            <div>
                <textarea class="commentTextArea" name="comment"></textarea>
            </div>
        </form>
    </div>
</body>

</html>