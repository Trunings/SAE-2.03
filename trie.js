document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('filtre-fruit').addEventListener('change', filtre);
  document.getElementById('filtre-role').addEventListener('change', filtre);
  document.getElementById('tri-prenom').addEventListener('change', trie);

  function filtre() {
    const fruitChoisi = document.getElementById('filtre-fruit').value;
    const roleChoisi = document.getElementById('filtre-role').value;

    document.querySelectorAll('.utilisateur').forEach(utilisateur => {
      const fruit = utilisateur.getAttribute('data-classe');
      const role = utilisateur.getAttribute('data-role');

      const fruitOk = fruitChoisi === "" || fruit === fruitChoisi;
      const roleOk = roleChoisi === "" || role === roleChoisi;

      utilisateur.style.display = (fruitOk && roleOk) ? "block" : "none";
    });
  }

  function trie() {
    const triValeur = document.getElementById('tri-prenom').value;
    const conteneur = document.querySelector('.utilisateur-container');
    const utilisateurs = Array.from(document.querySelectorAll('.utilisateur'));

    utilisateurs.sort((a, b) => {
      const titreA = a.querySelector('h3').textContent.toLowerCase();
      const titreB = b.querySelector('h3').textContent.toLowerCase();

      if (triValeur === 'prenom_asc') {
        return titreA.localeCompare(titreB);
      } else if (triValeur === 'prenom_desc') {
        return titreB.localeCompare(titreA);
      } else {
        return 0;
      }
    });

    conteneur.innerHTML = '';
    utilisateurs.forEach(utilisateur => conteneur.appendChild(utilisateur));
  }

  filtre(); // Appliquer filtres initiaux si besoin
  trie();   // Appliquer tri initial
});