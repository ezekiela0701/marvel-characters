const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export async function fetchMarvelCharacters(limit, offset) {
  try {
    const response = await fetch(`${API_BASE_URL}/marvel/characters?limit=${limit}&offset=${offset}`);
    const result = await response.json();
    
    if (result.success) {
      return result.data;  // Retourner les données des personnages
    } else {
      throw new Error(result.message);
    }
  } catch (error) {
    console.error('Erreur lors de la récupération des personnages:', error);
    throw error;
  }
}
