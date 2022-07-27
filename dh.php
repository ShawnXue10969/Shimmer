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
        Demon Hunter Class Changes In Shadowlands 9.0.5
        <span id="pin2" class="pin">
            <?php
            if (isset($_SESSION["userid"])) {
            $sql = "SELECT * FROM pins WHERE userId = '$id' AND nid = 2;";
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
            <h3>Havoc</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=347461/unbound-chaos"></a>
                    (Talent) damage increased to 500% (was 300%).
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3>Covenant Abilities</h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=339894/elysian-decree"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321076/kyrian"></a>
                    ) damage reduced by 10% for 
                    <a href="https://ptr.wowhead.com/spell=212613/vengeance-demon-hunter"></a>s.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=350631/fodder-to-the-flame"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321078/necrolord"></a>
                    ) has been redesigned – Your damaging abilities have a chance to call forth a demon from the 
                    <a href="https://ptr.wowhead.com/zone=12841/theater-of-pain"></a>
                    for 25 seconds. 
                    <a href="https://ptr.wowhead.com/spell=185123/throw-glaive"></a>
                    deals lethal damage to the demon, which explodes on death, dealing damage to nearby enemies and healing you for 30% of your maximum health. The explosion deals reduced damage beyond 5 targets.
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=337431/the-hunt"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321077/night-fae"></a>
                    ) damage decreased by 10% for 
                    <a href="https://ptr.wowhead.com/spell=212613/vengeance-demon-hunter"></a>s.
                </li>
            </ul>
        </li>

        <li class="li-1">
            <h3><a href="https://ptr.wowhead.com/spell=348869/conduits"></a></h3>
            <ul>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=339895/repeat-decree"></a>
                    ( <a href="https://ptr.wowhead.com/spell=321076/kyrian"></a>
                    ) base damage now 15% (was 25%).
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=338671/fel-defender"></a>
                    now affects 
                    <a href="https://ptr.wowhead.com/spell=320639/fel-devastation"></a>
                    for 
                    <a href="https://ptr.wowhead.com/spell=212613/vengeance-demon-hunter"></a>s (was 
                    <a href="https://ptr.wowhead.com/spell=343010/fiery-brand"></a>
                    ).
                </li>
                <li class="li-2">
                    <a href="https://ptr.wowhead.com/spell=339048/demonic-parole"></a>
                    will no longer engage creatures in combat when 
                    <a href="https://ptr.wowhead.com/spell=217832/imprison"></a>
                     expires.
                </li>
            </ul>
        </li>
    </ul>

    <h4>Comments</h4>

    <form class='comment-form' action='includes/comment.inc.php' method='POST'>
    <?php
    if (isset($_SESSION["userid"])) {
        $id = $_SESSION["userid"];
    ?>
        <input type='hidden' name='uid' value='<?php echo $id; ?>'>
        <input type='checkbox' name='anonymous'>
        <label for='anonymous'>Anonymous</label>
    <?php
    } else {
        echo "<input type='hidden' name='uid' value='0'>";
    }
    ?>
        
        <input type='hidden' name='nid' value='2'>
        <input type='hidden' name='date' value='<?php echo date('Y-m-d H:i:s'); ?>'>
        <textarea name='message'></textarea><br>
        <button class='p-btn btn btn-primary' type='submit' name='submit-comment'>Comment</button>
    </form>

    <div class="comment-section">
        <?php
            require_once 'includes/dbh.inc.php';

            $sql = "SELECT * FROM comments WHERE nid = 2 LIMIT 3";
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
                    nid: 2
                });
                loadReady = false;
                setTimeout(
                    function() 
                    {
                        loadReady = true;
                    }, 500);
            }
        });

        const pin2 = document.querySelector("#pin2");
        const uid = <?php echo $id; ?>;
        pin2.addEventListener('click', function() {
            if (uid != 0) {
                $("#pin2").load('includes/pin.inc.php', {
                    uid: uid,
                    toggle: true,
                    nid: 2
                });
            } else {
                window.location.replace("login.php");
            }
            
        });
    });
    
</script>

<?php include 'footer.php' ?>