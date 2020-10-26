<?php
    require_once '../database/pdo.php';
    header("Content-Type: application/json; charset=UTF-8");
    if(isset($_GET['q'])){  
        $x = $_GET['q']; 
        //echo $x."\n";
    }else{
        $x = 'Default';
    }
    
    $bookData = array();
    //You have to use bindValue because of wildcard statements
    $query = 'SELECT w.author_id,w.book_id,w.year_published,a.fullName,b.isbn,b.title FROM written_by w,authors a,books b 
    WHERE (a.fullName like :uData OR b.title like :uData) AND a.author_id = w.author_id AND b.book_id = w.book_id';
    try{
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':uData',$x.'%');
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$rows){
            $bookData['Response'] = 'Failed';
            $bookData['Text'] = 'No matches found';
        }else{
            $bookData += $rows;
        }
    }catch(PDOException $e){
        echo "\n Hata!!: ".$e->getMessage();
        $bookData['Response'] = 'Failed';
        $bookData['Text'] = $e->getMessage();
        die();
    }
    //echo "<pre>".print_r($bookData)."</pre>";
    echo json_encode($bookData);
    


