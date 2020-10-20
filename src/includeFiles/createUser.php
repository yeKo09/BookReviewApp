<?php
    if(isset($_POST['signUpButton'])){
        $query1 = "INSERT INTO users(username,email,u_password,name,surname,about,
        member_since,user_from,birth_date,gender)
        VALUES(:userName,:uEmail,:uPassword,:uName,:uSurname,:uAbout,:uSince,:uFrom,:uDate,:uGender);";
        try{
            $stmt3 = $pdo->prepare($query1);
            $date = $_POST['userBirthDate'];
            $currentDate = date('Y-m-d');
            $originalDate = $_POST['userBirthDate'];
            $newDate = date('Y-m-d',strtotime($originalDate));
            $stmt3->execute(array(
                ':userName' => $_POST['userName'],
                ':uEmail' => $_POST['userEmail'],
                ':uPassword' => $_POST['userPassword'],
                ':uName' => $_POST['myName'],
                ':uSurname' => $_POST['mySurname'],
                ':uAbout' => $_POST['aboutUser'],
                ':uSince' => $currentDate,
                ':uFrom' => $_POST['userFrom'],
                ':uDate' => $newDate,
                ':uGender' => $_POST['gender']
            ));
        }catch(PDOException $e){
            echo "Error!!: " . $e->getMessage() . "<br>";
            die();
        }
        /*Now,user will automatically log in but for navbar purposes i have to get the id of the user*/
        $query2 ="SELECT * FROM users u WHERE u.username = :userName";
        $stmt4 = $pdo->prepare($query2);
        $stmt4->execute(array(
            ':userName' => $_POST['userName']
        ));
        $row = $stmt4->fetch(PDO::FETCH_ASSOC);
        if($row){
            $_SESSION['userLoggedIn'] = true;
            createNewUser($row);
            /*The website will remember your information on your very first login to the website.*/
            $_SESSION['rememberMe'] = true;
        }else{
            echo "There has been a mistake";
            die();
        }
        header($lHolder);
        return;
    }
?>

    
    <form method="POST" id="signUp">
            <div id="signUpCont">
                <input type="text" name="userName" id="userName" placeholder="Username" size="15" required>
                <input type="email" name="userEmail" id="userEmail" placeholder="Email" size="20" required>
                <input type="password" name="userPassword" id="userPassword" placeholder="Password" size="15" required>
                <input type="text" name="myName" id="myName" placeholder="Your name" size="15" required>
                <input type="text" name="mySurname" id="mySurname" placeholder="Your surname" size="15" required>
                <textarea name="aboutUser" id="aboutUser" placeholder="About you(255 Characters)" rows="4" cols="30" maxlength="255"></textarea>
                <select name="userFrom" id="userFrom">
                    <option value="Default"selected>Select your Country</option>
                    <option value="Usa">Usa</option>
                    <option value="Canada">Canada</option>
                    <option value="Mexico">Mexico</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Germany">Germany</option>
                    <option value="United Kingdom">United Kingdom</option>
                    <option value="France">France</option>
                    <option value="Ukraine">Ukraine</option>
                    <option value="Turkey">Turkey</option>
                    <option value="Nigeria">Nigeria</option>
                    <option value="Russia">Russia</option>
                    <option value="India">India</option>
                    <option value="Japan">Japan</option>
                    <option value="Australia">Australia</option>
                </select>
                <input type="date" name="userBirthDate" id="userBirthDate" min="1930-01-01" max="2020-12-31" required>
                <input type="radio" name="gender" id="gender1" value="F">
                <label for="gender1">Female</label>
                <input type="radio" name="gender" id="gender2" value="M">
                <label for="gender2">Male</label>
                <input type="radio" name="gender" id="gender3" value="O">
                <label for="gender3">Other</label>
                <input type="submit" name="signUpButton" id="signUpButton" class="cBtn sUpBtn" value="Sign Up!">
            </div>
        </form>
    
