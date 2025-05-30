// Script pour gérer les effets de parallaxe et l'apparition du texte
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.section');
    
    // Ajouter les classes nécessaires aux éléments
    sections.forEach(section => {
        const background = section.querySelector('img');
        const content = section.querySelector('.contenu');
        
        // Ajouter la classe pour le parallaxe
        if (background) {
            background.classList.add('parallax-bg');
        }
        
        // Préparer le contenu pour l'animation (initialement caché)
        if (content) {
            content.style.opacity = '0';
            content.style.transform = 'translateY(20px)';
        }
    });
    
    // Fonction pour vérifier si un élément est visible dans la fenêtre
    function isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        // Une section est considérée "visible" uniquement quand elle est centrée dans la fenêtre
        return (
            rect.top <= (window.innerHeight * 0.4) && 
            rect.bottom >= (window.innerHeight * 0.6)
        );
    }
    
    // Fonction pour gérer le scroll
    function handleScroll() {
        sections.forEach(section => {
            const content = section.querySelector('.contenu');
            const background = section.querySelector('.parallax-bg');
            
            if (isElementInViewport(section)) {
                // Si la section est visible
                if (background) {
                    background.classList.add('darkened');
                }
                
                if (content) {
                    content.style.opacity = '1';
                    content.style.transform = 'translateY(0)';
                }
            } else {
                // Si la section n'est plus visible
                if (background) {
                    background.classList.remove('darkened');
                }
                
                if (content) {
                    content.style.opacity = '0';
                    content.style.transform = 'translateY(20px)';
                }
            }
        });
    }
    
    // Écouter l'événement de défilement avec throttling pour améliorer les performances
    let isScrolling = false;
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            window.requestAnimationFrame(function() {
                handleScroll();
                isScrolling = false;
            });
            isScrolling = true;
        }
    });
    
    // Exécuter une fois au chargement pour initialiser les sections visibles
    window.addEventListener('load', function() {
        // Retarder légèrement pour s'assurer que tout est bien chargé
        setTimeout(handleScroll, 200);
    });
    
    // Exécuter une première fois pour les éléments déjà visibles
    handleScroll();
});