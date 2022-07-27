<?php 
    include 'header.php';

    date_default_timezone_set('Australia/Brisbane');
    require_once 'includes/dbh.inc.php';
    $id = 0;
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION["userid"];
    }
    $nid = 3;
?>


<div class="main">
    <h2>
        Druid Class Changes In Shadowlands 9.0.5
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
            <h3>Restoration</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=231040/rejuvenation"></a>
                    's periodic healing increased by 12%.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=328025/wild-growth"></a>
                    healing increased by 7%.
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3>Covenant Abilities</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=335935/adaptive-swarm"></a>
                     ( <a href="https://ptr.wowhead.com/spell=321078/necrolord"></a>
                     ) damage and healing increased by 25% and the effectiveness of periodic effects increased to 25% (was 20%). The effectiveness of periodic effects increased to 35% for Balance Druids.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=337433/convoke-the-spirits"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321077/night-fae"></a>
                    ) can no longer cast 
                    <a href="https://ptr.wowhead.com/spell=202771/full-moon"></a>
                    and <a href="https://ptr.wowhead.com/spell=274837/feral-frenzy"></a>
                    for Guardian or Restoration Druids.
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3><a href="https://ptr.wowhead.com/spell=348869/conduits"></a></h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=341383/endless-thirst"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321079/venthyr"></a>
                    ) now increases your critical strike chance by .8% per stack at Rank 1 (was .5%).
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
                    nid: 3
                });
                loadReady = false;
                setTimeout(
                    function() 
                    {
                        loadReady = true;
                    }, 500);
            }
        });

        const pin3 = document.querySelector("#pin3");
        const uid = <?php echo $id; ?>;
        pin3.addEventListener('click', function() {
            if (uid != 0) {
                $("#pin3").load('includes/pin.inc.php', {
                    uid: uid,
                    toggle: true,
                    nid: 3
                });
            } else {
                window.location.replace("login.php");
            }
            
        });
    });
    
</script>

<?php include 'footer.php' ?>