//affichache de menu
function showMenu() {
    var menu = document.getElementById('nav-menu');
    if (menu.style.display === "none") {
        menu.style.display = "flex";
    } else {
        menu.style.display = "none";
    }
}


//formulaire de connexion 
 //Fonction pour afficher/masquer le formulaire de connexion
function toggleLoginForm() {
  var loginForm = document.querySelector('.login-form');
  loginForm.classList.toggle('active');
}

// Ajouter un écouteur d'événement pour l'icône de connexion
document.getElementById('login-btn').addEventListener('click', toggleLoginForm);

// Récupérer le formulaire de connexion
var loginForm = document.querySelector('.login-form form');

// Ajouter un écouteur d'événement pour le formulaire de connexion
loginForm.addEventListener('submit', function(event) {
    event.preventDefault(); // Empêcher le formulaire de se soumettre normalement

    //Récupérer les valeurs des champs du formulaire
    var username = loginForm.querySelector('input[name="username"]').value;
    var password = loginForm.querySelector('input[name="password"]').value;
    var remember = loginForm.querySelector('input[name="remember"]').checked;

    // Envoyer les données du formulaire à un fichier PHP pour traitement
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'login.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
           // Traiter la réponse du serveur
          console.log(xhr.responseText);
       }
   };
    xhr.send('username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password) + '&remember=' + remember);
});

//formulaire d'admin
document.addEventListener('DOMContentLoaded', () => {
  const menuIcon = document.getElementById('menu-icon');
  const loginIcon = document.getElementById('login-icon');
  const navbar = document.querySelector('.navbar ul');
  const loginForm = document.getElementById('login-form');

  // Toggle navigation bar
  menuIcon.addEventListener('click', () => {
      navbar.classList.toggle('active');
  });

  // Toggle login form
  loginIcon.addEventListener('click', () => {
      loginForm.classList.toggle('active');
      loginForm.classList.toggle('hidden');
  });

  // Optional: Close login form if clicking outside of it
  document.addEventListener('click', (event) => {
      if (!loginForm.contains(event.target) && !loginIcon.contains(event.target)) {
          loginForm.classList.add('hidden');
          loginForm.classList.remove('active');
      }
  });
});



//services js
document.addEventListener('DOMContentLoaded', function() {
  const prevButton = document.querySelector('.prev-button');
  const nextButton = document.querySelector('.next-button');
  const cardContainer = document.querySelector('.card-container');
  const cards = document.querySelectorAll('.card');

  let currentIndex = 0;
  const cardWidth = cards[0].offsetWidth + 20; // width + margin-right

  prevButton.addEventListener('click', function() {
      if (currentIndex > 0) {
          currentIndex--;
          scrollToCard(currentIndex);
      }
  });

  nextButton.addEventListener('click', function() {
      if (currentIndex < cards.length - 1) {
          currentIndex++;
          scrollToCard(currentIndex);
      }
  });

  function scrollToCard(index) {
      const scrollX = index * cardWidth;
      cardContainer.scrollTo({
          left: scrollX,
          behavior: 'smooth'
      });
  }
});
//script avis visiteurs
document.getElementById('commentForm').addEventListener('submit', function(event) {
  event.preventDefault();
  
  let formData = new FormData(this);
  
  fetch('submit_comment.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
      alert('Votre avis a été soumis pour validation.');
      document.getElementById('commentForm').reset();
  })
  .catch(error => {
      console.error('Erreur:', error);
  });
});

window.onload = function() {
  const carousel = document.querySelector('.carousel-inner');
  const comments = document.querySelectorAll('.comment');
  const commentHeight = comments[0].offsetHeight;
  let index = 0;
  setInterval(function() {
      carousel.style.top = `-${index * commentHeight}px`;
      index = (index + 1) % comments.length;
  }, 3000);
};

