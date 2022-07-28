/*fetch('https://raider.io/api/v1/mythic-plus/runs?season=season-sl-1&region=world&dungeon=all&page=0')
    .then(res => res.json())
    .then(data => console.log(data))
*/

var page = 0;

async function loadLeaderboard(region) {
    var loadBtn = document.querySelector(".spinner-border");
    loadBtn.classList.remove("visually-hidden");
    if (page == 5) {
        var e = document.createElement("p");
        e.innerHTML = 'The whole leaderboard has been loaded!';
        document.querySelector("#lb").appendChild(e);
        page += 1;
        loadBtn.classList.add("visually-hidden");
        loadBtn.parentElement.disabled = true;
        loadBtn.scrollIntoView();
        return;
    }
    else if (page > 5) {
        return;
    }
    const url = 'https://raider.io/api/v1/mythic-plus/runs?season=season-sl-1&region='+region+'&dungeon=all&page='+page;
    page += 1;
    const response = await fetch(url);
    const data = await response.json();
    const rankings = data.rankings;

    rankings.forEach(i => {
        var run = i.run;
        
        var modifiers = [];
        run.weekly_modifiers.forEach(m => {
            modifiers.push(m.id);
        });

        var tank = [];
        var healer = [];
        var dps = [];
        run.roster.forEach(c => {
            var name = c.character.name.split("-").shift();
            var character = {
                name: name,
                class_id: c.character.class.id,
                class: c.character.class.name,
                spec: c.character.spec.name,
                role: c.role
            };
            switch(character.role) {
                case 'tank':
                    tank.push(character);
                    break;
                case 'healer':
                    healer.push(character);
                    break;
                case 'dps':
                    dps.push(character);
                    break;
            }
        });

        var rankItem = {
            rank: i.rank,
            score: i.score,
            dungeon: run.dungeon.name,
            dungeon_short: run.dungeon.short_name,
            level: run.mythic_level,
            upgrade: run.num_chests,
            time: ms2Time(run.clear_time_ms),
            faction: run.faction,
            affixes: modifiers,
            tank: tank,
            healer: healer,
            dps: dps
        };

        //create the rank item DOM element
        var e = document.createElement("div");
        e.className = 'row d-flex justify-content-between';
        var dungeonWrap = document.createElement("div");
        dungeonWrap.className = 'dungeon-wrap ms-2 col-md-3 col-xl-4 d-flex justify-content-between';
        dungeonWrap.innerHTML += '<div class="cell col-1 d-flex justify-content-center"><span>'+ rankItem.rank +'</span></div>';
        dungeonWrap.innerHTML += '<div class="cell col-1 d-flex justify-content-center"><span class="has-tooltip" data-tooltip="' + rankItem.dungeon + '">'+ rankItem.dungeon_short +'</span></div>';
        
        switch (rankItem.upgrade) {
            case 1:
                var upgrade = '<i class="upgrade fas fa-angle-up"></i>';
                var upgradeTooltip = 'Keystone upgraded by 1';
                break;
            case 2:
                var upgrade = '<i class="upgrade fas fa-angle-double-up"></i>';
                var upgradeTooltip = 'Keystone upgraded by 2';
                break;
        }

        dungeonWrap.innerHTML += '<div class="cell col-1 d-flex justify-content-center"><span class="has-tooltip" data-tooltip="' + upgradeTooltip + '">'+ rankItem.level + upgrade + '</span></div>';
        dungeonWrap.innerHTML += '<div class="cell col-1 d-flex justify-content-center can-hide"><span>'+ rankItem.time +'</span></div>';
        dungeonWrap.innerHTML += '<div class="cell col-1 d-flex justify-content-center can-hide"><span>'+ rankItem.score +'</span></div>';
        e.appendChild(dungeonWrap);
        
        var affixes = document.createElement("div");
        affixes.classList.add("cell","col-1","affix-wrap","d-flex","justify-content-center");
        
        rankItem.affixes.forEach(a => {
            affixes.innerHTML += '<a href="//wowhead.com/affix=' + a + '"><img src="src/images/affixes/' + a + '.jpg"></a>';
        });

        e.appendChild(affixes);

        var tanks = document.createElement("div");
        tanks.classList.add("cell","col-1","tank-wrap");
        var healers = document.createElement("div");
        healers.classList.add("cell","col-1","healer-wrap");
        var dps = document.createElement("div");
        dps.classList.add("cell","col-3","dps-wrap");

        rankItem.tank.forEach(t => {
            tanks.innerHTML += '<span class="has-tooltip c' + t.class_id + '" data-tooltip="' + t.spec + ' ' + t.class + '">'+ t.name +'</span>';
        });
        rankItem.healer.forEach(h => {
            healers.innerHTML += '<span class="has-tooltip c' + h.class_id + '" data-tooltip="' + h.spec + ' ' + h.class + '">'+ h.name +'</span>';
        });
        rankItem.dps.forEach(d => {
            dps.innerHTML += '<span class="has-tooltip c' + d.class_id + '" data-tooltip="' + d.spec + ' ' + d.class + '">'+ d.name +'</span>';
        });

        e.appendChild(tanks);
        e.appendChild(healers);
        e.appendChild(dps);
        
        document.querySelector("#lb").appendChild(e);
        loadBtn.classList.add("visually-hidden");
        if (page != 1) {
            loadBtn.scrollIntoView();
        }
    });
}

function ms2Time(duration) {
    var seconds = Math.floor((duration / 1000) % 60),
    minutes = Math.floor((duration / (1000 * 60)) % 60),
    hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

  hours = (hours < 10) ? "0" + hours : hours;
  minutes = (minutes < 10) ? "0" + minutes : minutes;
  seconds = (seconds < 10) ? "0" + seconds : seconds;

  return hours + ":" + minutes + ":" + seconds;
  }

loadLeaderboard('world', 2);