const menu = document.getElementById('menu');
const nav = document.getElementById('navbar');
const li = document.querySelectorAll("li")
const header = document.getElementById("header")
const main = document.getElementById("main")
const footer = document.getElementById("footer")
const body = document.querySelector("body")

//adiciona um oucinte de evento para o clique do menu hamburguer
menu.addEventListener("click", () => {
    //verifica se a navbar possui a classe hide
    if (nav.classList.contains("hide")) {
        //mostra a navbar(menu)
        nav.classList.add("show")
        nav.classList.remove("hide")
        main.style.opacity="0.5"
        footer.style.opacity="0.5"
       
       body.classList.add("no-scroll2")
       header.style.filter="brightness(50%)"
       main.classList.add("no-scroll")
       header.classList.add("no-scroll")

    }
})

// Adiciona um ouvinte de evento para o clique no documento
document.addEventListener('click', function (event) {
    const isClickInsideMenu = nav.contains(event.target) || menu.contains(event.target);

    // Verifica se o clique ocorreu dentro do menu ou no ícone do menu hamburguer
    if (!isClickInsideMenu && nav.classList.contains("show")) {
        // Esconde o menu
        nav.classList.remove("show")
        nav.classList.add("hide")
        main.style.opacity=""
        footer.style.opacity=""
        body.classList.remove("no-scroll")
       header.style.filter=""
       main.classList.remove("no-scroll")
       header.classList.remove("no-scroll")
       body.classList.remove("no-scroll2")
    }
})





function redirectWithDelay(event) {
  event.preventDefault(); // Impede o redirecionamento padrão do href
  var delay = 500;

  // Obter o valor do atributo href corretamente usando getAttribute
  var targetHref = event.currentTarget.getAttribute('href');

  // Adiciona um atraso antes de redirecionar para a nova página
  setTimeout(function() {
    window.location.href = targetHref;
  }, delay);
}

  const target = document.querySelectorAll("[data-anime]")

  window.addEventListener("load",()=>{
    target.forEach((e)=>{
        e.classList.add("anime")
    })
  })

  function active() {
   
    if (nav.classList.contains("show")) {
        //esconde a navbar
        nav.classList.remove("show")
        nav.classList.add("hide")
        main.style.opacity=""
        footer.style.opacity=""
        body.classList.remove("no-scroll")
        header.style.filter=""
        
       
        
    }

}
  li.forEach((item) => {
    //adiciona um ouvinte de evento para o clique de cada item da navbar
    item.addEventListener("click", active)
})

$('.carousel').carousel({
  interval: false
})


var darkModeSwitch = document.getElementById('darkModeSwitch');
 
var navbar = document.getElementById('navbar');

var lis = document.querySelectorAll('li');

var ativado = document.getElementById('ativado');

// Verifica se a condição está armazenada no localStorage
if (localStorage.getItem('darkMode') === 'true') {
  darkModeSwitch.checked = true;
  applyDarkMode(); // Aplica o modo escuro
}

darkModeSwitch.addEventListener('change', function() {
  if (darkModeSwitch.checked) {
    localStorage.setItem('darkMode', 'true');
    applyDarkMode(); // Aplica o modo escuro
  } else {
    localStorage.setItem('darkMode', 'false');
    removeDarkMode(); // Remove o modo escuro
  }
});

function applyDarkMode() {
  // Aplica as alterações de estilo correspondentes
  ativado.classList.add('active-2');
  footer.classList.add('darken-mode');
  header.style.backgroundColor = 'rgb(190, 153, 58)'
  navbar.style.backgroundColor = 'rgb(190, 153, 58)';

  lis.forEach(function(li) {
    li.addEventListener('mouseenter', function() {
      this.style.backgroundColor = '#6F5233';
    });

    li.addEventListener('mouseleave', function() {
      this.style.backgroundColor = '';
    });
  });
}

function removeDarkMode() {
  // Remove as alterações de estilo correspondentes
  ativado.classList.remove('active-2');
  footer.classList.remove('darken-mode');
  header.style.backgroundColor = '';
  navbar.style.backgroundColor = '';

  lis.forEach(function(li) {
    li.addEventListener('mouseenter', function() {
      this.style.backgroundColor = '';
    });

    li.addEventListener('mouseleave', function() {
      this.style.backgroundColor = '';
    });
  });
}
