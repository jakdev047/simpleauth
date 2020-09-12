<?php
    // session start
    session_start([
        'cookie_lifetime'=> 300
    ]);

    // variable 
    $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
    $fp = fopen("./data/user.txt","r");
    $error = false;

    // initial session create
    $_SESSION['login'] = false;

    // username & password chewck
    if( $username && $password ) {
        while($data = fgetcsv($fp)) {
            if( $data[0] == $username && $data[1] == sha1($password) ) {
                $_SESSION['login'] = true;
                // header('location:index.php');
            }
        }

        if( !$_SESSION['login'] ) {
            $error = true;
        }
    }

    if( isset($_POST['logout'])) {
        $_SESSION['login'] = false;
        session_destroy();
    }
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Auth</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.0/milligram.css">

        <style>
            body{margin-top: 30px;}
        </style>

    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="column column-60 column-offset-20">
                    <h2>Simple User Authentication</h2>
                    <?php 
                        if( true == $_SESSION['login']){
                            echo "<p>Hello Admin Welcome!</p>";
                        }
                        else {
                            echo "<p>Hello Stranger Loghin below.</p>";
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="column column-60 column-offset-20"> 
                    <?php
                        if($error) {
                            echo "<blockquote>Username & Password don't match</blockquote>";
                        }
                        if( false == $_SESSION['login']): 
                    ?>
                        <form  method="POST">
                            <label for="username">User Name</label>
                            <input type="text" id="username" name="username">

                            <label for="password">Password</label>
                            <input type="password" id="password" name="password">

                            <button type="submit" class="button-primary">Submit</button>
                        </form>
                    <?php else: ?>
                        <form action="index.php"  method="POST">
                            <input type="hidden" name="logout" value="1"> 
                            <button type="submit" class="button-primary">Logout</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
