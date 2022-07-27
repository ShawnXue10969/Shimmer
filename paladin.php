<?php 
    include 'header.php';

    date_default_timezone_set('Australia/Brisbane');
    require_once 'includes/dbh.inc.php';
    $id = 0;
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION["userid"];
    }
    $nid = 5;
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
            <h3>Holy</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=289941/holy-shock"></a>
                    now costs 16% mana (was 14%).
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3>Protection</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=31850/ardent-defender"></a>
                    's heal now has a visual effect.
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3>Covenant Abilities</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=335939/vanquishers-hammer"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321078/necrolord"></a>
                    ) now generates 1 Holy Power when used.
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3><a href="https://ptr.wowhead.com/spell=348869/conduits"></a></h3>
            <ul>
                <li class="li-2">
                    The extra spells from 
                    <a href="https://ptr.wowhead.com/spell=340218/ringing-clarity"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321076/kyrian"></a>
                    ) now have a longer delay between hits. Additionally, area-of-effect 
                    <a href="https://ptr.wowhead.com/spell=20271/judgment"></a>
                    hits from 
                    <a href="https://ptr.wowhead.com/spell=314594/divine-toll"></a>
                    are no longer reduced by 25% in PvP, and 
                    <a href="https://ptr.wowhead.com/spell=20271/judgment"></a>
                    triggered from 
                    <a href="https://ptr.wowhead.com/spell=340218/ringing-clarity"></a>
                    is reduced by 25% in PvP.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=339518/virtuous-command"></a>
                    no longer plays an attack animation when it triggers.
                </li>
                <li class="li-2">
                    Fixed an issue that caused the additional 
                    <a href="https://ptr.wowhead.com/spell=85256/templars-verdict"></a>
                    from Templar's Vindication to not deal damage based on the initial 
                    <a href="https://ptr.wowhead.com/spell=85256/templars-verdict"></a>.
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
                    nid: 5
                });
                loadReady = false;
                setTimeout(
                    function() 
                    {
                        loadReady = true;
                    }, 500);
            }
        });

        const pin5 = document.querySelector("#pin5");
        const uid = <?php echo $id; ?>;
        pin5.addEventListener('click', function() {
            if (uid != 0) {
                $("#pin5").load('includes/pin.inc.php', {
                    uid: uid,
                    toggle: true,
                    nid: 5
                });
            } else {
                window.location.replace("login.php");
            }
            
        });
    });
    
</script>

<?php include 'footer.php' ?>