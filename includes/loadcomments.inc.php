<?php
            $commentCount = $_POST['commentCount'];
            $nid = $_POST['nid'];

            require_once 'dbh.inc.php';

            $sql = "SELECT * FROM comments WHERE nid = ".$nid." LIMIT ".$commentCount;
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='comment-wrap'>
                    <div class='author-wrap'>";
        
        if ($row['userId'] != 0) {
            $sql = "SELECT * FROM profiles WHERE userId = ".$row['userId'];
            $img = mysqli_query($conn, $sql);
            if(mysqli_num_rows($img) > 0) {
                while ($imgrow = mysqli_fetch_assoc($img)) {
                    echo "<div class='comment-img-wrap'>";
                    echo "<img class='comment-img' src='src/profile/".$imgrow['userId'].".".$imgrow['type']."'>";
                    echo "</div>";
                }
            }
        } else {
            echo "<div class='comment-img-wrap'>
            <i class='fas fa-user-circle'></i>
            </div>";
        }
            echo "<span class='author'>";
            $sql = "SELECT * FROM users WHERE userId = ".$row['userId'];
            $user = mysqli_query($conn, $sql);
            if(mysqli_num_rows($user) > 0) {
                while ($userrow = mysqli_fetch_assoc($user)) {
                    echo $userrow['userFullName'];
                }
            } else {
                echo "Anonymous";
            }
            echo "</span>";
            if ($row['userId'] != 0) {
                echo "<span class='author-id'>";
                echo "&nbsp;#".$row['userId'];
            }
            echo "</span>
            </div>";
        
            echo $row['message'];
            echo "</div>";
                }
            } else {
                echo "There are no comments yet!";
            }
?>