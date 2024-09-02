<template>
    <div class="character-card">
      <img :src="character.thumbnail" :alt="character.name" class="character-img" />
      <h3 class="character-name">{{ character.name }}</h3>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CharacterCard',
    props: {
      character: {
        type: Object,
        required: true
      }
    }
  };
  </script>
  
  <style scoped>
  .character-card {
    text-align: center;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    max-width: 150px;
  }
  .character-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 10px;
  }
  .character-name {
    font-size: 16px;
    font-weight: bold;
  }
  </style>
  