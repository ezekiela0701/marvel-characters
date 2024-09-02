<template>
    <div class="page-title">
      <h2>Marvel Characters Trombinoscope</h2>
    </div>
  
    <div class="trombinoscope">
      <div v-if="characters.length === 0">
        Loading characters...
      </div>
      <div v-else>
        <div class="character-grid">
          <CharacterCard 
            v-for="character in characters" 
            :key="character.name" 
            :character="character" 
          />
        </div>
      </div>
  
      <!-- Pagination controls -->
      <div class="pagination">
        <button @click="prevPage" :disabled="offset === 0">Précédent</button>
        <button @click="nextPage">Suivant</button>
      </div>
    </div>
  </template>
  
  <script>
  import { fetchMarvelCharacters } from '@/services/marvelApi';
  import CharacterCard from '@/components/CharacterCard.vue';
  
  export default {
    components: {
      CharacterCard
    },
    data() {
      return {
        characters: [],
        limit: 20,
        offset: 0
      };
    },
    mounted() {
      this.loadCharacters();
    },
    methods: {
      async loadCharacters() {
        try {
          this.characters = await fetchMarvelCharacters(this.limit, this.offset);
        } catch (error) {
          console.error('Erreur lors du chargement des personnages:', error);
        }
      },
      nextPage() {
        this.offset += this.limit;
        this.loadCharacters();
      },
      prevPage() {
        if (this.offset > 0) {
          this.offset -= this.limit;
          this.loadCharacters();
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .page-title {
    text-align: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f5f5f5;
    border-radius: 8px;
  }
  .page-title h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0;
  }
  
  .pagination {
    margin-top: 20px;
    display: flex;
    justify-content: space-between;
  }
  .pagination button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .pagination button:disabled {
    background-color: #cccccc;
  }
  
  .character-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    padding: 10px;
  }
  </style>
  