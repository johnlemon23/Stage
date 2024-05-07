
// Empecher la soumission du formulaire lorsque la touche "Entree" est enfoncee
document.addEventListener("keydown", function(event) {
  if (event.key === "Enter") {
    event.preventDefault();
  }
});

// auto completion de la commune en fonction du code postal

  let villesString = "";
  let villesStringPrec = "";

  function ajouterOptions(communes) {
    const villesArray = communes.split(",");
    const selectVilles = document.getElementById("commune");
    selectVilles.innerHTML = "";
    villesArray.forEach(ville => {
      const option = document.createElement("option");
      option.text = ville;
      option.value = ville;
      selectVilles.add(option);
    });
    
  }

  document.getElementById("code_postal").addEventListener("change", function() {
    var codePostalInput = document.getElementById("code_postal").value;
    // Envoyer une requete HTTP POST contenant la valeur du champ de formulaire
    var xhr = new XMLHttpRequest();
    var method = "POST";
    var urls = "Controllers/ajax.php";
    var async = true;

    xhr.open(method, urls, async);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("code_postal=" + encodeURIComponent(codePostalInput));

    xhr.onload = function() {
      if (this.readyState == 4 && this.status === 200) {
        // Traitement de la reponse du script PHP
        var data = this.responseText;
        if (data !== villesStringPrec) {
          // Stocker la reponse dans la variable villesString
          villesString = data;
          villesStringPrec = data;
          
          // Executer la fonction pour mettre a jour les options
          ajouterOptions(data);
        }
      } else {
        console.error("Erreur lors de la requête : " + xhr.status);
        console.log("erreur");
      }
    };
  });

// Ajout du formulaire par personne inscrite
  function ajouterForm() {
      var formRepete = document.getElementById("form-repete");
      var nombreInput = document.getElementById("nombre_adherent");
      var nombre = parseInt(nombreInput.value);
      var forms = document.querySelectorAll("#form-repete");
      if (nombre < 11){
        for (var i = forms.length; i < nombre; i++) {
          var clone = formRepete.cloneNode(true);
          formRepete.parentNode.insertBefore(clone, formRepete.nextSibling);
        }
        for (var i = forms.length - 1; i >= nombre; i--) {
          forms[i].parentNode.removeChild(forms[i]);
        }
      }
  }

// Ajout input
function ajoutInput(currentInputId, nextInputId) {
  var inputValue = document.getElementById(currentInputId).value;
  var nextInput = document.getElementById(nextInputId);

  if (inputValue.trim() !== "") {
    // Si l'input actuel n'est pas vide, affiche l'input suivant
    nextInput.style.display = "inline";
  } else {
    // Si l'input actuel est vide, masque l'input suivant
    nextInput.style.display = "none";
  }
}