<?php include_once 'header.php'; ?>

<div class="main">
    <h1>Mythic+ Timed Run Leaderboard</h1>
    <div id="lb">
        <div class="row d-flex justify-content-between">
            <div class="dungeon-wrap col-md-3 col-xl-4 d-flex justify-content-between">
                <div class="ms-2 cell col-1 d-flex justify-content-center">
                    <span>
                        Rank
                    </span>
                </div>
                <div class="cell col-1 d-flex justify-content-center">
                    <span>
                        Dungeon
                    </span>
                </div>
                <div class="cell col-1 d-flex justify-content-center">
                    <span>
                        Level
                    </span>
                </div>
                <div class="cell col-1 d-flex justify-content-center can-hide">
                    <span>
                        Time
                    </span>
                </div>
                <div class="cell col-1 d-flex justify-content-center can-hide">
                    <span>
                        Score
                    </span>
                </div>
            </div>
            
            <div class="cell col-1 affix-wrap d-flex justify-content-center">
                <span>
                    Affixes
                </span>
            </div>
            <div class="cell col-1 tank-wrap">
                <span>
                    Tank
                </span>
            </div>
            <div class="cell col-1 healer-wrap">
                <span>
                    Healer
                </span>
            </div>
            <div class="cell col-3 dps-wrap">
                <span>
                    Dps
                </span>
            </div>
        </div>
    </div>
    <button class="btn btn-load btn-warning" onclick="loadLeaderboard('world')">
        <span class="spinner-border spinner-border-sm text-dark me-2 visually-hidden" role="status" aria-hidden="true"></span>
        Load more
    </button>
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
    });
</script>
<script src="js/fetch.js"></script>
<?php include_once 'footer.php'; ?>