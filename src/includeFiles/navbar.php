<?php
    require_once '../database/pdo.php';
    function getGenres($pdo){
        $query = "SELECT * FROM genres";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    $rows = getGenres($pdo);
?>
    <nav>
        <div class="container clearfix">
            <div class="navTitle">
                <h1 id="actualTitle">yekoreads</h1>
            </div>
            <div class="navSearchBox">
                <form method="GET" id="searchForm" action="searchBooks.php">
                    <select name="genres" id="genres">
                        <option value='default' selected disabled>Genres</option>
                        <?php
                            for($i=0; $i<count($rows); $i++){
                                echo "<option value='".$rows[$i]['genre_id']."'>".$rows[$i]['genre_name'].
                                "</option>";
                                echo "\n";
                            }
                        ?>
                    </select>
                    <input type="text" name="searchBooks" id="searchBooks" size="50" placeholder = "Title/Author to search the books">
                    <input type="submit" class="cBtn" name="searchBooksBtn" id="searchBooksBtn" value="Search">
                </form>
            </div>
            <div class="navInfo">
                <?php 
                    if($_SESSION['userLoggedIn']){
                        echo "<a href='".$_SESSION['user']->getID()."' target='_self'>My Account</a>";
                    }else{
                        echo "<span>Log in</span>";
                    }
                ?>
            </div>
        </div>
    </nav>
    <div id="bookResults" class="clearfix">
        <div id="bookData" class="clearfix"></div>
    </div>
    <script src="../includeFiles/navbar.js"></script>
</body>
</html>