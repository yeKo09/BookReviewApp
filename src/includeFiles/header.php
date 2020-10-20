<?php
    require_once '../database/pdo.php';
    include 'user.php';
    session_start();
    $lHolder = "Location:".$_SERVER['PHP_SELF'];
    if(!isset($_SESSION['userLoggedIn'])){
        $_SESSION['userLoggedIn'] = false;
        
    }

    if(!isset($_SESSION['user'])){
        $_SESSION['user'] = new User();
    }

    if(!isset($_SESSION['triedToLogin'])){
        $_SESSION['triedToLogin'] = false;
    }

    if(!isset($_SESSION['rememberMe'])){
        $_SESSION['rememberMe'] = false;
    }

    function createNewUser($row){
        $user = new User();
        $user->setID($row['user_id']);
        $user->setUserName($row['username']);
        $user->setPassword($row['u_password']);
        $user->setEmail($row['email']);
        $user->setFirstName($row['name']);
        $user->setLastName($row['surname']);
        $user->setAbout($row['about']);
        $user->setMemberSince($row['member_since']);
        $user->setFrom($row['user_from']);
        $user->setBirthDate($row['birth_date']);
        $user->setGender($row['gender']);
        $_SESSION['user'] = $user;
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
            createNewUser($row);
            if(isset($_POST['rememberUser']) && $_POST['rememberUser'] === 'Yes'){
                $_SESSION['rememberMe'] = true;
            }else{
                $_SESSION['rememberMe'] = false;
            }
        }else{
            $_SESSION['userLoggedIn'] = false;
            $_SESSION['triedToLogin'] = true;
            $_SESSION['rememberMe'] = false;
        }
        /*POST-REDIRECT-GET*/
        header($lHolder);
        return;
    }


    if(isset($_POST['logOut'])){
        if($_SESSION['rememberMe']){
            $remindMe = true;
            $userName = $_SESSION['user']->getUserName();
            $password = $_SESSION['user']->getPassword();
        }
        session_destroy();
        session_start();
        if($remindMe){
            $_SESSION['rememberMe'] = true;
            $_SESSION['user'] = new User();
            $_SESSION['user']->setUserName($userName);
            $_SESSION['user']->setPassword($password);
        }
        /*POST-REDIRECT-GET*/ 
        header($lHolder);
        return;
    }
?>
    <header>
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
                        { echo $_SESSION['user']->getUserName(); }else{ echo "";}?>' required>
                    </div>
                    <div class="loginBox">
                        <input type="password" name="uPword" id="uPword" placeholder="Password" size="15"
                        value='<?php if($_SESSION['rememberMe'])
                        { echo $_SESSION['user']->getPassword(); }else{ echo "";}?>' required>
                    </div>
                    <input type="submit" name="loginBtn" id="loginBtn" value="Sign in" class="cBtn">
                    <button type="button" id="createBtn" value="Sign up" class="cBtn sUpBtn">Sign up!</button>
                    <br><input type="checkbox" name="rememberUser" id="rememberUser" value="Yes" checked>
                    <label for="rememberUser" id="rmm">Remember me</label>
                </form>
                <?php if($_SESSION['triedToLogin']){echo "<div class='failBox'>
                You have failed to login.Please try again!</div>";
                unset($_SESSION['triedToLogin']);
                }  ?>
            <?php }else{?>
                <div id="loggedIn">
                    <?php echo "<span id='userNamePlace'>Successfully logged in as " 
                    . "<a href='".$_SESSION['user']->getID() . "' target='_self' class='linkToProfile'>"
                    .$_SESSION['user']->getUserName(). "</a>" . "</span>";?>
                    <form method="POST" style="display:inline-block;">
                        <input type="submit" class="cBtn" value="Log out" name="logOut">
                    </form>
                </div>
                <?php }}?>
        </div>
    </header>
    <div class="clearfix"></div>
    <div id="signUpBox">
        <?php include 'createUser.php'?>
    </div>
    <script src="header.js">
    </script>
    
