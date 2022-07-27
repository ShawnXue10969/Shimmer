<?php
include 'header.php';
require_once 'includes/dbh.inc.php';

if (isset($_SESSION["userid"])) {
    $id = $_SESSION["userid"];
} else {
    header("Location: login.php");
}
?>

<div class="main">
    <h2>Pinned</h2>
    <div class="menu">
        <?php
        $sql = "SELECT * FROM pins WHERE userId = '$id';";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $nid = $row['nid'];
            echo '<div class="card text-white">
            <img src="src/images/'.$nid.'.svg" class="card-img">
            <div class="card-img-overlay d-flex">
                <div class="pin-wrap">
                    <h4 id="pin'.$nid.'" class="pin">
                    <i class="fas fa-star"></i>
                    </h4>
                </div>';
                switch ($nid) {
                    case 1:
                        $href = "dk.php";
                        $title = "Death Knight Class Changes In Shadowlands 9.0.5";
                        break;
                    case 2:
                        $href = "dh.php";
                        $title = "Demon Hunter Class Changes In Shadowlands 9.0.5";
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
            if ($pName == "index" || $pName == "leaderboard") {
                echo 'console.log("1");';
            }
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
        if(pin1) {
            pin1.addEventListener('click', function() {
                if (uid) {
                    $("#pin1").load('includes/pin.inc.php', {
                        uid: uid,
                        toggle: true,
                        nid: 1
                    });
                    window.location.replace("pinned.php");
                } else {
                    window.location.replace("login.php");
                }
                
            });
        }
        if(pin2) {
            pin2.addEventListener('click', function() {
                if (uid) {
                    $("#pin2").load('includes/pin.inc.php', {
                        uid: uid,
                        toggle: true,
                        nid: 2
                    });
                    window.location.replace("pinned.php");
                } else {
                    window.location.replace("login.php");
                }
                
            });
        }
        if(pin3) {
            pin3.addEventListener('click', function() {
                if (uid) {
                    $("#pin3").load('includes/pin.inc.php', {
                        uid: uid,
                        toggle: true,
                        nid: 3
                    });
                    window.location.replace("pinned.php");
                } else {
                    window.location.replace("login.php");
                }
                
            });
        }
        if(pin4) {
            pin4.addEventListener('click', function() {
                if (uid) {
                    $("#pin4").load('includes/pin.inc.php', {
                        uid: uid,
                        toggle: true,
                        nid: 4
                    });
                    window.location.replace("pinned.php");
                } else {
                    window.location.replace("login.php");
                }
                
            });
        }
        if(pin5) {
            pin5.addEventListener('click', function() {
                if (uid) {
                    $("#pin5").load('includes/pin.inc.php', {
                        uid: uid,
                        toggle: true,
                        nid: 5
                    });
                    window.location.replace("pinned.php");
                } else {
                    window.location.replace("login.php");
                }
                
            });
        }
        
    });
</script>

<?php include 'footer.php' ?>