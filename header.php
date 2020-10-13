<?php
    require_once 'pdo.php';
    session_start();
    $lHolder = "Location:".$_SERVER['PHP_SELF'];
    if(!isset($_SESSION['userLoggedIn'])){
        $_SESSION['userLoggedIn'] = false;
    }
    if(!isset($_SESSION['rememberMe'])){
        $_SESSION['rememberMe'] = false;
    }
    if(isset($_POST['loginBtn']) && isset($_POST['email_or_username']) && isset($_POST['uPword'])){
        $sql = "SELECT * FROM users u WHERE (u.username = :udata OR u.email= :udata) AND u.u_password = :upword";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':udata' => $_POST['email_or_username'],
            ':upword' => $_POST['uPword']
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            $_SESSION['userLoggedIn'] = true;
            $_SESSION['userId'] = $row['user_id'];
            $_SESSION['userName'] = $row['username'];
            $_SESSION['uPword'] = $_POST['uPword'];
            if(isset($_POST['rememberUser']) && $_POST['rememberUser'] === 'Yes'){
                $_SESSION['rememberMe'] = true;
            }else{
                $_SESSION['rememberMe'] = false;
            }
        }else{
            $_SESSION['userLoggedIn'] = false;
        }
        /*POST-REDIRECT-GET*/ 
        header($lHolder);
        return;
    }
    if(isset($_POST['logOut'])){
        if($_SESSION['rememberMe']){
            $remindMe = true;
            $userName = $_SESSION['userName'];
            $password = $_SESSION['uPword'];
        }
        session_destroy();
        session_start();
        if($remindMe){
            $_SESSION['rememberMe'] = true;
            $_SESSION['userName'] = $userName;
            $_SESSION['uPword'] = $password;
        }
        /*POST-REDIRECT-GET*/ 
        header($lHolder);
        return;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="mandatory.css">
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <header class="clearfix">
        <div class="container clearfix">  
            <h1 class="greet">Let's Review a Book!</h1>
            <?php
                if(isset($_SESSION['userLoggedIn'])){
                    if(!$_SESSION['userLoggedIn']){
            ?>
                <form method="POST" id="loginForm">
                    <div class="loginBox">
                        <input type="text" name="email_or_username" id="email_or_username" placeholder="Email/Username"
                        size="15" value='<?php if($_SESSION['rememberMe'])
                        { echo $_SESSION['userName']; }else{ echo "";}?>' required>
                    </div>
                    <div class="loginBox">
                        <input type="password" name="uPword" id="uPword" placeholder="Password" size="15"
                        value='<?php if($_SESSION['rememberMe'])
                        { echo $_SESSION['uPword']; }else{ echo "";}?>' required>
                    </div>
                    <input type="submit" name="loginBtn" value="Sign in" class="cBtn">
                    <input type="submit" name="createBtn" value="Sign up" class="cBtn"><br>
                    <input type="checkbox" name="rememberUser" id="rememberUser" value="Yes" checked>
                    <label for="rememberUser" id="rmm">Remember me</label>
                </form>
            <?php }else{?>
                <div id="loggedIn">
                    <?php echo "<span id='userNamePlace'>Successfully logged in as " 
                    . "<a href='#SessionUserIdBurayaGelecek' target='_self' class='linkToProfile'>"
                    .$_SESSION['userName']. "</a>" . "</span>";?>
                    <form method="POST" style="display:inline-block;">
                        <input type="submit" class="cBtn" value="Log out" name="logOut">
                    </form>
                    <?php }}?>
                </div>
        </div>
    <header>
</body>
</html>