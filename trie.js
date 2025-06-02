document.addEventListener('DOMContentLoaded', function () {

  // Attache les gestionnaires d'événement aux filtres et au tri une fois que le DOM est prêt
  document.getElementById('filtre-fruit').addEventListener('change', filtre);
  document.getElementById('filtre-role').addEventListener('change', filtre);
  document.getElementById('tri-prenom').addEventListener('change', trie);

  // Fonction de filtrage en fonction du fruit et du rôle choisis
  function filtre() {
    const fruitChoisi = document.getElementById('filtre-fruit').value;
    const roleChoisi = document.getElementById('filtre-role').value;

    document.querySelectorAll('.utilisateur').forEach(utilisateur => {
      const fruit = utilisateur.getAttribute('data-classe');
      const role = utilisateur.getAttribute('data-role');

      // Vérifie si chaque utilisateur correspond aux filtres
      const fruitOk = fruitChoisi === "" || fruit === fruitChoisi;
      const roleOk = roleChoisi === "" || role === roleChoisi;

      // Affiche ou masque l'utilisateur selon les conditions
      utilisateur.style.display = (fruitOk && roleOk) ? "block" : "none";
    });
  }

  // Fonction de tri des utilisateurs par prénom
  function trie() {
    const triValeur = document.getElementById('tri-prenom').value;
    const conteneur = document.querySelector('.utilisateur-container');
    const utilisateurs = Array.from(document.querySelectorAll('.utilisateur'));

    utilisateurs.sort((a, b) => {
      // Prend le premier <h3> comme prénom
      const titreA = a.querySelector('h3').textContent.toLowerCase();
      const titreB = b.querySelector('h3').textContent.toLowerCase();

      // Trie alphabétique croissant ou décroissant
      if (triValeur === 'prenom_asc') {
        return titreA.localeCompare(titreB);
      } else if (triValeur === 'prenom_desc') {
        return titreB.localeCompare(titreA);
      } else {
        return 0;
      }
    });

    // Réinjection des éléments triés dans le conteneur
    conteneur.innerHTML = '';
    utilisateurs.forEach(utilisateur => conteneur.appendChild(utilisateur));
  }

  // Applique le filtrage et le tri dès le chargement initial
  filtre();
  trie();
});