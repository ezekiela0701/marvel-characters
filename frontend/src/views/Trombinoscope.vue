<template>
    <div class="page-title">
      <h2>Marvel Characters Trombinoscope</h2>
    </div>
  
    <div class="trombinoscope">
        <div v-if="isLoading">
          <p>Loading characters...</p>
        </div>
      <div v-else>
        <div v-if="characters.length === 0">
          <p>No characters found.</p>
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
        offset: 0,
        total: 0,         
        isLoading: false  

      };
    },
    mounted() {
      this.loadCharacters();
    },
    methods: {
      async loadCharacters() {

        this.isLoading = true; 

        try {

          this.characters = await fetchMarvelCharacters(this.limit, this.offset);

        } catch (error) {

          console.error('Erreur lors du chargement des personnages:', error);

        }finally {

          this.isLoading = false;  

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
  /* Style du titre de la page */
  .page-title {
    text-align: center;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #f5f5f5;
    border-radius: 8px;
  }
  .page-title h2 {
    font-size: 20px;
    font-weight: bold;
    color: #333;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin: 0;
  }
  
  /* Trombinoscope grid - Mobile first */
  .character-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
    padding: 10px;
    justify-items: center;
  }
  
  /* Pagination styles */
  .pagination {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 5px;
  }
  .pagination button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  .pagination button.active {
    background-color: #0056b3; /* Highlight the active page */
  }
  .pagination button:disabled {
    background-color: #cccccc;
  }
  
  /* Responsive adjustments for tablet screens (min-width: 600px) */
  @media screen and (min-width: 600px) {
    .character-grid {
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
    }
  
    .page-title h2 {
      font-size: 24px;
    }
  }
  
  /* Responsive adjustments for larger screens (min-width: 900px) */
  @media screen and (min-width: 900px) {
    .character-grid {
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
  
    .page-title h2 {
      font-size: 28px;
    }
  }
  
  /* Responsive adjustments for desktop screens (min-width: 1200px) */
  @media screen and (min-width: 1200px) {
    .character-grid {
      grid-template-columns: repeat(4, 1fr);
      gap: 30px;
    }
  
    .page-title h2 {
      font-size: 32px;
    }
  }
  </style>
  