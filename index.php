<?php
include_once 'header.php';
require_once 'includes/dbh.inc.php';

$id = 0;

if (isset($_SESSION["userid"])) {
    $id = $_SESSION["userid"];
}
?>

<div class="main">
    <h2>Home</h2>
    <div class="menu">
    <?php
        $news = 0;
        while ($news < 5) {
            $news += 1;
            echo '<div class="card text-white">
            <img src="src/images/'.$news.'.svg" class="card-img">
            <div class="card-img-overlay d-flex">
                <div class="pin-wrap">
                    <h4 id="pin'.$news.'" class="pin">';
                    if (isset($_SESSION["userid"])) {
                        $sql = "SELECT * FROM pins WHERE userId = '$id' AND nid = '$news';";
                        $result = $conn->query($sql);
                        if ($row = mysqli_fetch_assoc($result)) {
                            echo '<i class="fas fa-star"></i>';
                        } else {
                            echo '<i class="far fa-star"></i>';
                        }
                    } else {
                        echo '<i class="far fa-star"></i>';
                    }
                    echo '</h4>
                </div>';
                switch ($news) {
                    case 1:
                        $href = "dk.php";
                        $title = "Death Knight Class Changes In Shadowlands 9.0.5";
                        //echo'<h4 class="ms-3"><a href="dk.php">Death Knight Class Changes In Shadowlands 9.0.5</a></h4>';
                        break;
                    case 2:
                        $href = "dh.php";
                        $title = "Demon Hunter Class Changes In Shadowlands 9.0.5";
                        //echo'<h4 class="ms-3"><a href="dh.php">Demon Hunter Class Changes In Shadowlands 9.0.5</a></h4>';
                        break;
                    case 3:
                        $href = "druid.php";
                        $title = "Druid Class Changes In Shadowlands 9.0.5";
                        break;
                    case 4:
                        $href = "mage.php";
                        $title = "Mage Class Changes In Shadowlands 9.0.5";
                        break;
                    case 5:
                        $href = "paladin.php";
                        $title = "Paladin Class Changes In Shadowlands 9.0.5";
                        break;
                }
                echo'<h4 class="ms-3"><a href="'.$href.'">'.$title.'</a></h4>
            </div>
        </div>';
            
        }
        ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        <?php
            $pName = basename(__FILE__, ".php");
        ?>
        const pName = '<?php echo $pName ?>';
        switch(pName) {
            case 'index':
                document.querySelector("#l_home").classList.add("active");
                break;
            case 'leaderboard':
                document.querySelector("#l_leaderboard").classList.add("active");
                break;
            case 'profile':
                document.querySelector("#l_profile").classList.add("active");
                document.querySelector("#user-collapse").classList.add("show");
                document.querySelector("#user-toggle").setAttribute("aria-expanded", "true");
                break;
            case 'pinned':
                document.querySelector("#l_pinned").classList.add("active");
                document.querySelector("#user-collapse").classList.add("show");
                document.querySelector("#user-toggle").setAttribute("aria-expanded", "true");
                break;
        }

        const pin1 = document.querySelector("#pin1");
        const pin2 = document.querySelector("#pin2");
        const pin3 = document.querySelector("#pin3");
        const pin4 = document.querySelector("#pin4");
        const pin5 = document.querySelector("#pin5");
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

<?php include_once 'footer.php'; ?>