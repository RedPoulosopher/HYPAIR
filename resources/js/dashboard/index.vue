<template>
  <div class="page-container">
    <div class="header-section">
      <h1>Tableau de bord Administrateur</h1>
      <div v-if="user" class="user-info">
        <p>
          Bienvenue, <strong>{{ user.prenom }} {{ user.nom }}</strong> !
        </p>
        <div class="user-actions">
          <NuxtLink to="/" class="btn btn-secondary">Accueil</NuxtLink>
          <NuxtLink to="/dashboard/tele" class="btn btn-primary">Affichage Télé</NuxtLink>
          <button @click="handleLogout" class="btn btn-secondary">
            Se déconnecter
          </button>
        </div>
      </div>
    </div>

    <div class="content-card">
      <div class="filters-section">
        <div class="form-group">
          <label for="search">Rechercher un utilisateur :</label>
          <input
            type="text"
            v-model="searchQuery"
            id="search"
            placeholder="Nom, prénom..."
            class="form-control"
          />
        </div>
        <div class="form-group">
          <label for="colorFilter">Filtrer par équipe :</label>
          <select v-model="selectedColor" id="colorFilter" class="form-control">
            <option value="">Toutes</option>
            <option v-for="color in availableColors" :key="color" :value="color">
              {{ teamNames[color] || color }}
            </option>
          </select>
        </div>
      </div>
      <div class="table-header">
        <h2>Liste des utilisateurs</h2>
        <NuxtLink to="/dashboard/add-user" class="btn btn-primary">
          Ajouter un utilisateur
        </NuxtLink>
      </div>
      <div v-if="pending" class="loading-message">
        Chargement des utilisateurs...
      </div>
      <div v-else-if="error" class="error-message">
        <p>
          Une erreur est survenue lors de la récupération des utilisateurs :
          {{ error.statusMessage }}
        </p>
      </div>
      <div class="table-container">
        <table v-if="paginatedUsers.length">
          <thead>
            <tr>
              <th>ID</th>
              <th>Prénom</th>
              <th>Nom</th>
              <th>Équipe</th>
              <th>Points</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in paginatedUsers" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.prenom }}</td>
              <td>{{ user.nom }}</td>
              <td>{{ teamNames[user.couleur_equipe] || user.couleur_equipe }}</td>
              <td>{{ user.points }}</td>
              <td class="actions-cell">
                <PatchUser
                  :user="user"
                  @user-updated="refreshUsers"
                  @error="handleError"
                />
                <AddPointsUser
                  :userId="user.id"
                  :userPoints="user.points"
                  :nom="user.nom"
                  :prenom="user.prenom"
                  @points-added="refreshUsers"
                  @error="handleError"
                />
                <DeleteUser
                  :user-id="user.id"
                  :nom="user.nom"
                  :prenom="user.prenom"
                  @user-deleted="refreshUsers"
                  @error="handleError"
                />
              </td>
            </tr>
          </tbody>
        </table>
        <div v-else-if="!pending && !error" class="info-message">
          <p v-if="users?.data?.length === 0">
            Aucun utilisateur n'a été créé pour le moment.
            <NuxtLink
              to="/dashboard/add-user"
              class="text-indigo-600 hover:underline"
              >Ajoutez-en un !</NuxtLink
            >
          </p>
          <p v-else>
            Aucun utilisateur ne correspond à vos critères de recherche.
          </p>
        </div>
      </div>

      <!-- Pagination Controls -->
      <div v-if="totalPages > 1" class="pagination-controls">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="btn btn-secondary"
        >
          Précédent
        </button>
        <span>Page {{ currentPage }} sur {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="btn btn-secondary"
        >
          Suivant
        </button>
        <select v-model="itemsPerPage" class="form-control items-per-page">
          <option :value="5">5 par page</option>
          <option :value="10">10 par page</option>
          <option :value="20">20 par page</option>
          <option :value="50">50 par page</option>
          <option :value="100">100 par page</option>
        </select>
      </div>
      <div
        v-else-if="!pending && !error && filteredUsers.length > 0"
        class="info-message"
      >
        Affichage de {{ filteredUsers.length }} utilisateur(s).
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: "auth", // Protège cette page
});

interface UserData {
  id: string;
  prenom: string;
  nom: string;
  couleur_equipe: string;
  points: number;
}

const { user, clear } = useUserSession();
const searchQuery = ref("");
const selectedColor = ref("");
const currentPage = ref(1);
const itemsPerPage = ref(10); // Nombre d'éléments par page

const teamNames: Record<string, string> = {
  'Bleu': 'Les Légionnaires',
  'Rouge': 'Les Charleston',
  'Vert': 'Les Grrrrrrr',
  'Jaune': 'Les Templiers'
};

// Récupérer la liste des utilisateurs depuis notre API
const {
  data: users,
  pending,
  error,
  refresh,
} = useFetch<{ data: UserData[] }>("/api/users", {
  // `lazy: true` permet de ne pas bloquer la navigation pendant le chargement
  lazy: true,
});

const availableColors = computed(() => {
  if (!users.value?.data) return [];
  // Crée un ensemble de couleurs uniques à partir des utilisateurs
  const colors = new Set(users.value.data.map((user) => user.couleur_equipe));
  return Array.from(colors).filter(Boolean); // Filtre les valeurs null/undefined
});

const filteredUsers = computed(() => {
  if (!users.value?.data) {
    return [];
  }

  let filtered = users.value.data;

  // 1. Filtrer par couleur d'équipe
  if (selectedColor.value) {
    filtered = filtered.filter(
      (user) => user.couleur_equipe === selectedColor.value
    );
  }


  // 2. Filtrer par recherche textuelle
  if (searchQuery.value) {
    const search = searchQuery.value.toLowerCase();
    filtered = filtered.filter((user) =>
      `${user.prenom} ${user.nom}`.toLowerCase().includes(search)
    );
  }

  return filtered;
});

// Calcul du nombre total de pages
const totalPages = computed(() => {
  return Math.ceil(filteredUsers.value.length / itemsPerPage.value);
});

// Utilisateurs à afficher sur la page actuelle
const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return filteredUsers.value.slice(start, end);
});

// Fonctions de navigation
function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
}

function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
}

async function handleLogout() {
  await clear();
  await navigateTo("/login");
}

function refreshUsers() {
  refresh(); // Rafraîchit la liste des utilisateurs
}

function handleError(errorMessage: string) {
  // Optionnel : afficher l'erreur dans une notification globale si vous en avez une
  console.error(errorMessage);
}

// Réinitialiser la page courante si les filtres changent
watch([searchQuery, selectedColor, itemsPerPage], () => {
  currentPage.value = 1;
});
</script>
<style scoped lang="scss">
@use "~/assets/scss/variables" as *;
@use "~/assets/scss/buttons";
@use "~/assets/scss/forms";

.page-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.header-section {
  text-align: center;
  margin-bottom: 2rem;

  h1 {
    font-size: 2.25rem;
    font-weight: 700;
    color: $gray-900;
  }

  .user-info {
    margin-top: 1rem;
    color: $gray-600;
  }

  .user-actions {
    margin-top: 0.5rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
  }
}

.content-card {
  background-color: $white;
  padding: 2rem;
  border-radius: 0.75rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
    0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.filters-section {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
  margin-bottom: 2rem;

  @media (min-width: 768px) {
    grid-template-columns: 1fr 1fr;
  }
}

.table-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  flex-wrap: wrap;
  gap: 1rem;

  @media (max-width: 480px) {
    flex-direction: column;
  }

  h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: $gray-800;
  }
}

.loading-message,
.info-message {
  text-align: center;
  padding: 2rem;
  color: $gray-600;
}

.error-message {
  color: $red-500;
  text-align: center;
  padding: 2rem;
}

.table-container {
  overflow-x: auto;
}

/* Styles pour la vue "carte" sur mobile */
@media (max-width: 767px) {
  .table-container {
    overflow-x: hidden;
  }

  table,
  thead,
  tbody,
  th,
  td,
  tr {
    display: block;
  }

  thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  tr {
    border: 1px solid $gray-200;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
  }

  td {
    border: none;
    border-bottom: 1px solid $gray-100;
    position: relative;
    padding-left: 50%;
    text-align: right;
    white-space: normal;
  }

  td:before {
    position: absolute;
    top: 0.75rem;
    left: 1rem;
    width: 45%;
    padding-right: 0.5rem;
    white-space: nowrap;
    text-align: left;
    font-weight: 600;
    color: $gray-700;
  }

  /* Labels pour chaque cellule */
  td:nth-of-type(1):before {
    content: "ID";
  }
  td:nth-of-type(2):before {
    content: "Prénom";
  }
  td:nth-of-type(3):before {
    content: "Nom";
  }
  td:nth-of-type(4):before {
    content: "Équipe";
  }
  td:nth-of-type(5):before {
    content: "Points";
  }

  .actions-cell {
    justify-content: flex-end;
    padding-left: 1rem; /* Pas de label pour les actions */
    min-width: 0; /* On annule la largeur minimale */
  }

  .actions-cell:before {
    content: ""; /* On cache le label pour la cellule d'actions */
  }
}

table {
  width: 100%;
  text-align: left;
  border-collapse: collapse;

  th,
  td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid $gray-200;
    vertical-align: middle;
  }

  thead th {
    font-weight: 600;
    color: $gray-600;
    background-color: $gray-50;
  }

  tbody tr:hover {
    background-color: $gray-50;
  }

  .actions-header {
    text-align: right;
  }

  .actions-cell {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;

    @media (min-width: 768px) {
      min-width: 220px; // Empêche les actions de se comprimer sur plusieurs lignes
    }
  }
}

.pagination-controls {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.75rem;
  margin-top: 2rem;
  flex-wrap: wrap;
  color: $gray-700;
  font-size: 0.875rem;

  .items-per-page {
    width: auto;
    margin-left: 1rem;
  }
}

.btn {
  padding: 0.5rem 1rem;
  font-size: 0.875rem;
}
</style>
