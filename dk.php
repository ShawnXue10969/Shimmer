<?php 
    include 'header.php';

    date_default_timezone_set('Australia/Brisbane');
    require_once 'includes/dbh.inc.php';

    $id = 0;
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION["userid"];
    }
?>


<div class="main">
    <h2>
        Death Knight Class Changes In Shadowlands 9.0.5
        <span id="pin1" class="pin">
            <?php
            if (isset($_SESSION["userid"])) {
            $sql = "SELECT * FROM pins WHERE userId = '$id' AND nid = 1;";
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
            <h3>Frost</h3>
            <ul>
                <li class="li-2">
                    Fixed an issue that caused 
                    <a href="https://ptr.wowhead.com/spell=253593/inexorable-assault"></a>
                    (Talent) to consume 
                    <a href="https://ptr.wowhead.com/spell=23920/spell-reflection"></a>
                    .
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3>Unholy</h3>
            <ul>
                <li class="li-2">
                    Fixed an issue that caused 
                    <a href="https://ptr.wowhead.com/spell=319230/unholy-pact"></a>
                    (Talent) to sometimes not hit large raid bosses.
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3>Covenant Abilities</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=312940/shackle-the-unworthy"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321076/kyrian"></a>
                    ) damage increased by 15% and damage reduction debuff increased to 8% (was 5%).
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=335933/abomination-limb"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321078/necrolord"></a>
                    ) now correctly deals damage and pulls in enemies while the 
                    <a href="https://ptr.wowhead.com/class=6/death-knight"></a>
                    <a class="c6" href="https://ptr.wowhead.com/death-knight"><img src="https://wow.zamimg.com/images/wow/icons/tiny/class_deathknight.gif" style="vertical-align: middle;"> <span>Death Knight</span></a>
                    is crowd-controlled.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=335933/abomination-limb"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321078/necrolord"></a>
                    ) no longer pulls in enemies that are in 
                    <a href="https://ptr.wowhead.com/spell=1784/stealth"></a>
                    .
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=337430/deaths-due"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321077/night-fae"></a>
                    ) damage reduction debuff and Strength buff increased to 2% per stack (was 1%). Now stacks up to 4 times (was 8).
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
        
        <input type='hidden' name='nid' value='1'>
        <input type='hidden' name='date' value='<?php echo date('Y-m-d H:i:s'); ?>'>
        <textarea name='message'></textarea><br>
        <button class='p-btn btn btn-primary' type='submit' name='submit-comment'>Comment</button>
    </form>

    <div class="comment-section">
        <?php
            require_once 'includes/dbh.inc.php';

            $sql = "SELECT * FROM comments WHERE nid = 1 LIMIT 3";
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
                    nid: 1
                });
                loadReady = false;
                setTimeout(
                    function() 
                    {
                        loadReady = true;
                    }, 500);
            }
        });

        const pin1 = document.querySelector("#pin1");
        const uid = <?php echo $id; ?>;
        pin1.addEventListener('click', function() {
            if (uid != 0) {
                $("#pin1").load('includes/pin.inc.php', {
                    uid: uid,
                    toggle: true,
                    nid: 1
                });
            } else {
                window.location.replace("login.php");
            }
            
        });
    });
    
</script>

<?php include 'footer.php' ?>