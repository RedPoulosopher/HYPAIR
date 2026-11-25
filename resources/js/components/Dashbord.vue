<template>
    <div class="dashboard">
        <!-- EQUIPES -->
        <section class="teams-section">
            <div class="teams-grid">

                <article
                    v-for="(team, index) in sortedTeams"
                    :key="team.id"
                    class="team-card"
                    :class="[team.color, { leader: index === 0 }]"
                >
                    <div class="rank">
                        #{{ index + 1 }}
                    </div>

                    <div class="team-logo">
                        <img
                            v-if="team.logo"
                            :src="team.logo"
                            :alt="team.name"
                        >
                        <span v-else>{{ team.emoji }}</span>
                    </div>

                    <div class="team-name">
                        {{ team.name }}
                    </div>

                    <div class="team-points">
                        {{ team.points.toLocaleString('fr-FR') }}
                    </div>

                    <div class="points-label">POINTS</div>

                    <div class="leader-badge" v-if="index === 0">
                        👑 EN TÊTE
                    </div>
                </article>

            </div>

        </section>


        <!-- DONATION GOAL -->
        <section class="donation-section">

            <div class="donation-left">
                <span class="eyebrow">❤️ ENSEMBLE POUR LA RECHERCHE</span>
                <h2>DONATION GOAL</h2>
                <p>Chaque don nous rapproche de notre objectif !</p>
            </div>

            <div class="donation-right">

                <div class="donation-amounts">
                    <strong>
                        {{ formattedDonations }}
                    </strong>

                    <span>
                        / {{ formattedGoal }}
                    </span>
                </div>

                <div class="progress-bar">
                    <div
                        class="progress-fill"
                        :style="{ width: donationProgress + '%' }"
                    ></div>
                </div>

                <div class="progress-info">
                    <span>{{ donationProgress }} % DE L'OBJECTIF ATTEINT</span>
                    <span>OBJECTIF : {{ formattedGoal }}</span>
                </div>

            </div>

        </section>

        <!-- OBJECTIFS -->
        <section class="objectives-section">

            <div class="objectives-grid">

                <!-- OBJECTIFS RÉUSSIS -->
                <div class="objectives-card completed-card">
                    <h3>🏆 OBJECTIFS RÉUSSIS</h3>

                    <div
                        v-for="goal in completedGoals"
                        :key="goal.id"
                        class="goal-item completed"
                    >
                        <span class="goal-icon">✅</span>
                        <div>
                            <strong>{{ goal.title }}</strong>
                            <small>{{ goal.description }}</small>
                        </div>
                        <span class="goal-status">RÉUSSI</span>
                    </div>

                    <p v-if="completedGoals.length === 0" class="empty">
                        Aucun objectif atteint pour le moment.
                    </p>
                </div>

                <!-- OBJECTIFS FUTURS -->
                <div class="objectives-card future-card">
                    <h3>🚀 PROCHAINS OBJECTIFS</h3>

                    <div
                        v-for="goal in futureGoals"
                        :key="goal.id"
                        class="goal-item future"
                    >
                        <span class="goal-icon">🎯</span>
                        <div>
                            <strong>{{ goal.title }}</strong>
                            <small>{{ goal.description }}</small>
                        </div>
                        <span class="goal-status">À FAIRE</span>
                    </div>

                    <p v-if="futureGoals.length === 0" class="empty">
                        Tous les objectifs sont atteints !
                    </p>
                </div>

            </div>
        </section>

        <!-- CLASSEMENT INDIVIDUEL -->
        <section class="players-section">
            <div class="players-container">

                <div
                    v-for="(player, index) in sortedPlayers"
                    :key="player.id"
                    class="player-row"
                >

                    <div class="player-rank">
                        <span v-if="index === 0">🥇</span>
                        <span v-else-if="index === 1">🥈</span>
                        <span v-else-if="index === 2">🥉</span>
                        <span v-else>#{{ index + 1 }}</span>
                    </div>

                    <div
                        class="player-team-color"
                        :style="{ background: getTeamColor(player.teamId) }"
                    ></div>

                    <div class="player-info">
                        <strong>{{ player.name }}</strong>
                        <span>{{ getTeamName(player.teamId) }}</span>
                    </div>

                    <div class="player-points">
                        {{ player.points }} <small>PTS</small>
                    </div>

                </div>

            </div>

        </section>

    </div>
</template>


<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';


// =====================================
// EQUIPES
// =====================================

const teams = ref([
    {
        id: 1,
        name: 'LES LIONS',
        points: 1250,
        color: 'orange',
        emoji: '🦁',
        logo: null
    },
    {
        id: 2,
        name: 'LES TIGRES',
        points: 980,
        color: 'turquoise',
        emoji: '🐯',
        logo: null
    },
    {
        id: 3,
        name: 'LES REQUINS',
        points: 1540,
        color: 'pink',
        emoji: '🦈',
        logo: null
    },
    {
        id: 4,
        name: 'LES AIGLES',
        points: 1120,
        color: 'green',
        emoji: '🦅',
        logo: null
    }
]);


// =====================================
// PARTICIPANTS
// =====================================

const players = ref([
    { id: 1, name: 'Lucas Martin', teamId: 1, points: 450 },
    { id: 2, name: 'Emma Dupont', teamId: 3, points: 620 },
    { id: 3, name: 'Hugo Bernard', teamId: 2, points: 380 },
    { id: 4, name: 'Léa Petit', teamId: 4, points: 510 },
    { id: 5, name: 'Nathan Robert', teamId: 3, points: 490 },
    { id: 6, name: 'Chloé Richard', teamId: 1, points: 420 }
]);


// =====================================
// DONATIONS
// =====================================

const donations = ref(3250);
const donationGoal = ref(10000);


// =====================================
// CLASSEMENTS
// =====================================

const sortedTeams = computed(() => {
    return [...teams.value].sort((a, b) => b.points - a.points);
});

const sortedPlayers = computed(() => {
    return [...players.value].sort((a, b) => b.points - a.points);
});

const donationProgress = computed(() => {
    if (donationGoal.value <= 0) return 0;

    return Math.min(
        100,
        Math.round((donations.value / donationGoal.value) * 100)
    );
});

const formattedDonations = computed(() => {
    return formatMoney(donations.value);
});

const formattedGoal = computed(() => {
    return formatMoney(donationGoal.value);
});

function formatMoney(value) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
        maximumFractionDigits: 0
    }).format(value);
}


// =====================================
// INFORMATIONS EQUIPES
// =====================================

function getTeamName(id) {
    return teams.value.find(t => t.id === id)?.name ?? 'Sans équipe';
}

function getTeamColor(id) {
    const team = teams.value.find(t => t.id === id);

    const colors = {
        orange: '#F36B18',
        turquoise: '#13B4BC',
        pink: '#A90F58',
        green: '#91C51F'
    };

    return colors[team?.color] || '#FFFFFF';
}


// =====================================
// HORLOGE
// =====================================

const currentTime = ref('');

let clockInterval;

function updateClock() {
    currentTime.value = new Intl.DateTimeFormat('fr-FR', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    }).format(new Date());
}

onMounted(() => {
    updateClock();
    clockInterval = setInterval(updateClock, 1000);
});

onUnmounted(() => {
    clearInterval(clockInterval);
});



// =====================================
// OBJECTIFS DU TÉLÉTHON
// =====================================

const completedGoals = ref([
    {
        id: 1,
        title: '100 participants inscrits',
        description: 'La communauté BDH est mobilisée !'
    },
    {
        id: 2,
        title: '1 000 € récoltés',
        description: 'Un premier cap symbolique franchi.'
    }
]);

const futureGoals = ref([
    {
        id: 3,
        title: '5 000 € récoltés',
        description: 'Prochain objectif de collecte.'
    },
    {
        id: 4,
        title: '10 000 € récoltés',
        description: 'Atteindre notre objectif final.'
    },
    {
        id: 5,
        title: '200 participants',
        description: 'Mobiliser encore plus de monde.'
    }
]);
</script>


<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

* {
    box-sizing: border-box;
}

.dashboard {
    --yellow: #FFC914;
    --turquoise: #13B4BC;
    --green: #91C51F;
    --orange: #F36B18;
    --pink: #A90F58;
    --cream: #FFF9EC;
    --black: #101010;

    min-height: 100vh;
    padding: 45px 8%;
    color: var(--black);
    background: var(--cream);
    font-family: 'Montserrat', sans-serif;
    overflow-x: hidden;
}

/* TITRES DE SECTION */
.section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 28px;
    padding-bottom: 14px;
    border-bottom: 3px solid var(--black);
}

.section-heading h2 {
    margin: 0;
    font-size: clamp(17px, 2vw, 24px);
    font-weight: 900;
    letter-spacing: -0.5px;
}

.section-heading > span {
    padding: 8px 12px;
    background: var(--yellow);
    border: 2px solid var(--black);
    font-size: 9px;
    font-weight: 900;
    letter-spacing: 1px;
    white-space: nowrap;
    transform: rotate(-2deg);
}

/* CLASSEMENT DES ÉQUIPES */
.teams-section,
.objectives-section,
.players-section {
    margin-bottom: 25px;
}

.teams-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 22px;
}

.team-card {
    position: relative;
    min-height: 235px;
    padding: 25px 15px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: var(--black);
    border: 3px solid var(--black);
    box-shadow: 7px 7px 0 var(--black);
    transition: transform .25s, box-shadow .25s;
}

.team-card.orange { background: var(--orange); }
.team-card.turquoise { background: var(--turquoise); }
.team-card.pink { background: var(--pink); color: white; }
.team-card.green { background: var(--green); }

.team-card.leader {
    outline: 4px solid var(--yellow);
    outline-offset: 4px;
}

.rank {
    position: absolute;
    top: 12px;
    left: 14px;
    font-size: 14px;
    font-weight: 900;
}

.team-logo {
    height: 75px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 8px;
}

.team-logo img {
    width: 70px;
    height: 70px;
    object-fit: contain;
}

.team-logo span { font-size: 52px; }

.team-name {
    font-size: 13px;
    font-weight: 900;
    letter-spacing: 1px;
}

.team-points {
    margin-top: 8px;
    font-size: 42px;
    font-weight: 900;
    line-height: 1.1;
}

.points-label {
    font-size: 9px;
    font-weight: 900;
    letter-spacing: 3px;
}

.leader-badge {
    position: absolute;
    top: -15px;
    right: 10px;
    padding: 7px 10px;
    color: var(--black);
    background: var(--yellow);
    border: 2px solid var(--black);
    font-size: 9px;
    font-weight: 900;
    transform: rotate(4deg);
}

/* COLLECTE DE DONS */
.donation-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 40px;
    margin: 15px 0 25px;
    padding: 35px 40px;
    background: var(--turquoise);
    border: 3px solid var(--black);
    box-shadow: 8px 8px 0 var(--black);
}

.donation-left {
    min-width: 230px;
}

.eyebrow {
    display: inline-block;
    color: var(--pink);
    font-size: 10px;
    font-weight: 900;
    letter-spacing: 1.5px;
}

.donation-left h2 {
    margin: 12px 0;
    font-size: clamp(27px, 3vw, 38px);
    font-weight: 900;
    letter-spacing: -1.5px;
}

.donation-left p {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    line-height: 1.7;
}

.donation-right { flex: 1; min-width: 0; }

.donation-amounts {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.donation-amounts strong {
    color: var(--pink);
    font-size: clamp(30px, 4vw, 45px);
    font-weight: 900;
}

.donation-amounts span {
    font-size: 17px;
    font-weight: 800;
}

.progress-bar {
    width: 100%;
    height: 22px;
    overflow: hidden;
    background: var(--cream);
    border: 3px solid var(--black);
}

.progress-fill {
    height: 100%;
    background: var(--yellow);
    border-right: 2px solid var(--black);
    transition: width 1s ease;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 12px;
    font-size: 9px;
    font-weight: 900;
    letter-spacing: .7px;
}

/* OBJECTIFS */
.objectives-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 25px;
}

.objectives-card {
    padding: 28px;
    background: white;
    border: 3px solid var(--black);
    box-shadow: 7px 7px 0 var(--black);
}

.completed-card { background: #E7F4C9; }
.future-card { background: #FFF0B8; }

.objectives-card h3 {
    margin: 0 0 22px;
    font-size: 16px;
    font-weight: 900;
}

.goal-item {
    display: flex;
    align-items: center;
    gap: 13px;
    margin-bottom: 12px;
    padding: 15px;
    background: var(--cream);
    border: 2px solid var(--black);
}

.goal-icon { font-size: 25px; }

.goal-item div {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.goal-item strong {
    font-size: 12px;
    font-weight: 900;
}

.goal-item small {
    color: #555;
    font-size: 10px;
    line-height: 1.5;
}

.goal-status {
    font-size: 9px;
    font-weight: 900;
    white-space: nowrap;
}

.completed .goal-status { color: #4E7D00; }
.future .goal-status { color: #A56A00; }

.empty {
    margin-bottom: 0;
    font-size: 12px;
    font-weight: 600;
}

/* CLASSEMENT INDIVIDUEL */
.players-container {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 15px 22px;
}

.player-row {
    display: flex;
    align-items: center;
    gap: 15px;
    min-width: 0;
    padding: 15px 18px;
    background: white;
    border: 2px solid var(--black);
    box-shadow: 4px 4px 0 var(--black);
    transition: transform .2s;
}

.player-rank {
    width: 35px;
    flex-shrink: 0;
    font-size: 21px;
    font-weight: 900;
    text-align: center;
}

.player-team-color {
    width: 7px;
    height: 42px;
    flex-shrink: 0;
    border: 1px solid var(--black);
}

.player-info {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.player-info strong {
    overflow-wrap: anywhere;
    font-size: 13px;
    font-weight: 900;
}

.player-info span {
    color: #555;
    font-size: 10px;
    font-weight: 700;
}

.player-points {
    flex-shrink: 0;
    color: var(--pink);
    font-size: 23px;
    font-weight: 900;
}

.player-points small {
    font-size: 9px;
    color: var(--black);
}

/* RESPONSIVE */
@media (max-width: 950px) {
    .dashboard { padding: 35px 6%; }
    .teams-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .donation-section { align-items: stretch; flex-direction: column; gap: 25px; }
}

@media (max-width: 700px) {
    .dashboard { padding: 28px 5%; }
    .section-heading { align-items: flex-start; flex-direction: column; }
    .section-heading > span { align-self: flex-start; }
    .objectives-grid,
    .players-container { grid-template-columns: 1fr; }
    .objectives-card { padding: 22px; }
    .donation-section { padding: 25px 22px; }
    .donation-left { min-width: 0; }
    .progress-info { flex-direction: column; }
}

@media (max-width: 420px) {
    .teams-grid { gap: 15px; }
    .team-card { min-height: 190px; padding: 18px 8px; }
    .team-logo { height: 60px; }
    .team-logo img { width: 58px; height: 58px; }
    .team-logo span { font-size: 42px; }
    .team-name { font-size: 11px; }
    .team-points { font-size: 32px; }
    .leader-badge { right: 5px; font-size: 8px; }
    .player-row { gap: 10px; padding: 12px; }
    .player-points { font-size: 19px; }
    .goal-item { align-items: flex-start; flex-wrap: wrap; }
}
</style>