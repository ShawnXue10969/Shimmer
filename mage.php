<?php 
    include 'header.php';

    date_default_timezone_set('Australia/Brisbane');
    require_once 'includes/dbh.inc.php';
    $id = 0;
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION["userid"];
    }
    $nid = 4;
?>


<div class="main">
    <h2>
        Mage Class Changes In Shadowlands 9.0.5
        <span id="pin<?php echo $nid; ?>" class="pin">
            <?php
            if (isset($_SESSION["userid"])) {
            $sql = "SELECT * FROM pins WHERE userId = '$id' AND nid = '$nid';";
            $result = $conn->query($sql);
            if ($row = mysqli_fetch_assoc($result)) {
                echo '<i class="fas fa-star"></i>';
            } else {
                echo '<i class="far fa-star"></i>';
            } 
            } else {
                echo '<i class="far fa-star"></i>';
            }
            ?>
        </span>
    </h2>
    <ul class="news">
        <li class="li-1">
            <h3>Covenant Abilities</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=312950/radiant-spark"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321076/kyrian"></a>
                    ) damage increased by 20%.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=335936/deathborne"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321078/necrolord"></a>
                    ) duration increased to 25 seconds (was 20 seconds) and Spell Power buff increased to 15% (was 10%).
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=337048/mirrors-of-torment"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321079/venthyr"></a>
                    )
                    <ul>
                        <li>
                            Arcane: Now grants a stack of 
                            <a href="https://ptr.wowhead.com/spell=321758/clearcasting"></a>
                            when a mirror is consumed (was mana).
                        </li>
                        <li>
                            Fire: 
                            <a href="https://ptr.wowhead.com/spell=57984/fire-blast"></a>
                            cooldown reduction increased to 6 seconds (was 4 seconds).
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>

    <h4>Comments</h4>

    <form class='comment-form' action='includes/comment.inc.php' method='POST'>
    <?php
    if (isset($_SESSION["userid"])) {
    ?>
        <input type='hidden' name='uid' value='<?php echo $id; ?>'>
        <input type='checkbox' name='anonymous'>
        <label for='anonymous'>Anonymous</label>
    <?php
    } else {
        echo "<input type='hidden' name='uid' value='0'>";
    }
    ?>
        
        <input type='hidden' name='nid' value='<?php echo $nid; ?>'>
        <input type='hidden' name='date' value='<?php echo date('Y-m-d H:i:s'); ?>'>
        <textarea name='message'></textarea><br>
        <button class='p-btn btn btn-primary' type='submit' name='submit-comment'>Comment</button>
    </form>

    <div class="comment-section">
        <?php
            require_once 'includes/dbh.inc.php';

            $sql = "SELECT * FROM comments WHERE nid = '$nid' LIMIT 3";
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
    </div>
   
</div>

<script>
    $(document).ready(function() {
        var loadReady = true;
        var commentCount = 3;
        $(window).scroll(function(){
            if (loadReady == true && $(window).scrollTop() + $(window).height() > $(document).height() - 20){
                commentCount += 3;
                $(".comment-section").load("includes/loadcomments.inc.php", {
                    commentCount: commentCount,
                    nid: 4
                });
                loadReady = false;
                setTimeout(
                    function() 
                    {
                        loadReady = true;
                    }, 500);
            }
        });

        const pin4 = document.querySelector("#pin4");
        const uid = <?php echo $id; ?>;
        pin4.addEventListener('click', function() {
            if (uid != 0) {
                $("#pin4").load('includes/pin.inc.php', {
                    uid: uid,
                    toggle: true,
                    nid: 4
                });
            } else {
                window.location.replace("login.php");
            }
            
        });
    });
    
</script>

<?php include 'footer.php' ?>