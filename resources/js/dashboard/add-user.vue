<template>
  <div class="page-container">
    <div class="form-card">
      <h1 class="title">Ajouter un nouvel utilisateur</h1>
      <form @submit.prevent="handleAddUser" class="add-user-form">
        <div class="form-group">
          <label for="prenom">Prénom:</label>
          <input
            id="prenom"
            v-model="prenom"
            type="text"
            required
            class="form-control"
          />
        </div>
        <div class="form-group">
          <label for="nom">Nom:</label>
          <input
            id="nom"
            v-model="nom"
            type="text"
            required
            class="form-control"
          />
        </div>
        <div class="form-group">
          <label for="couleur_equipe">Équipe:</label>
          <select
            id="couleur_equipe"
            v-model="couleur_equipe"
            required
            class="form-control"
          >
            <option disabled value="">Choisir une équipe</option>
            <option value="Bleu">Les Légionnaires</option>
            <option value="Rouge">Les Charleston</option>
            <option value="Vert">Les Grrrrrrr</option>
            <option value="Jaune">Les Templiers</option>
          </select>
        </div>
        <div class="form-actions">
          <button type="submit" class="btn btn-primary" :disabled="isLoading">
            {{ isLoading ? "Ajout en cours..." : "Ajouter l'utilisateur" }}
          </button>
          <NuxtLink to="/dashboard" class="btn btn-secondary">Annuler</NuxtLink>
        </div>
        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
definePageMeta({
  middleware: "auth",
});

const nom = ref("");
const prenom = ref("");
const couleur_equipe = ref("");
const error = ref<string | null>(null);
const isLoading = ref(false);

async function handleAddUser() {
  if (isLoading.value) return;
  isLoading.value = true;
  error.value = null;

  // Déférer le travail lourd au prochain tick pour laisser le navigateur
  // terminer l'exécution de l'événement submit (réduire le temps bloquant)
  await new Promise((resolve) => setTimeout(resolve, 0));

  try {
    await $fetch("/api/users/addUser", {
      method: "POST",
      body: {
        nom: nom.value,
        prenom: prenom.value,
        couleur_equipe: couleur_equipe.value,
        points: 0,
      },
    });

    navigateTo("/dashboard");
  } catch (e: any) {
    error.value =
      e?.data?.statusMessage ||
      "Une erreur est survenue lors de la création de l'utilisateur.";
  } finally {
    isLoading.value = false;
  }
}
</script>
<style scoped lang="scss">
@use "~/assets/scss/variables" as *;
@use "~/assets/scss/buttons";
@use "~/assets/scss/forms";

.page-container {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background-color: $gray-100;
  padding: 1rem;
}

.form-card {
  width: 100%;
  max-width: 500px;
  background-color: $white;
  padding: 2.5rem;
  border-radius: 0.75rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
    0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.title {
  font-size: 1.875rem;
  font-weight: 700;
  text-align: center;
  color: $gray-900;
  margin-bottom: 2rem;
}

.add-user-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-actions {
  margin-top: 1.5rem;
  display: flex;
  gap: 1rem;
}

.btn {
  padding: 0.6rem 1.2rem;
  font-size: 0.875rem;

  &-secondary {
    background-color: transparent;
    &:hover {
      background-color: $gray-100;
    }
  }

  &:disabled {
    opacity: 0.7;
    cursor: not-allowed;
  }
}
.error-message {
  margin-top: 1rem;
  color: $red-500;
  font-size: 0.875rem;
}
</style>
