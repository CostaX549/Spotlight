<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="icon" href="/img/spotlight.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    

    <title>Spotlight+</title>
    
    <link rel="stylesheet" href="/css/style.css">
 
    
</head>

<body>
    <header id="header">
        <!-- Menu hamburguer -->
        <div class="menu" id="menu">
            <div class="linha"></div>
            <div class="linha"></div>
            <div class="linha"></div>
        </div>
      

    </header>

      <!-- Navbar -->
      <nav id="navbar" class="hide">
        <ul>
            <li  id="ativado" class="active"><svg  xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" onclick="redirectWithDelay(event)" href="sobre nos2.html">
                    <path fill="#FFFFFF" d="M10 20v-6h4v6h5v-8h3L12 3L2 12h3v8z" />
                </svg><a href="sobre nos2.html" class="list" onclick="redirectWithDelay(event)">Início</a></li>
         
            <li><svg onclick="redirectWithDelay(event)"  href="page3.html" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="#ffffff" d="M9 21c0 .5.4 1 1 1h4c.6 0 1-.5 1-1v-1H9v1zm3-19C8.1 2 5 5.1 5 9c0 2.4 1.2 4.5 3 5.7V17c0 .5.4 1 1 1h6c.6 0 1-.5 1-1v-2.3c1.8-1.3 3-3.4 3-5.7c0-3.9-3.1-7-7-7z"/></svg> <a href="page3.html" onclick="redirectWithDelay(event)">Plano de Negócios</a></li>
            <li><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" onclick="redirectWithDelay(event)" href="page5.html">
                <path fill="#FFFFFF" fill-rule="evenodd"
                    d="M16.67 13.13C18.04 14.06 19 15.32 19 17v3h4v-3c0-2.18-3.57-3.47-6.33-3.87z" />
                <circle cx="9" cy="8" r="4" fill="#FFFFFF" fill-rule="evenodd" />
                <path fill="#FFFFFF" fill-rule="evenodd"
                    d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4c-.47 0-.91.1-1.33.24a5.98 5.98 0 0 1 0 7.52c.42.14.86.24 1.33.24zm-6 1c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z" />
            </svg><a href="page5.html"onclick="redirectWithDelay(event)">Equipe/Colaboradores</a></li>
            <li class="equipe"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" onclick="redirectWithDelay(event)" href="index.html"><path fill="#ffffff" d="M8 19V5l11 7l-11 7Z"/></svg>
                <a href="index.html" onclick="redirectWithDelay(event)">Streaming</a></li>

        </ul>
        <br>
        <label id="switch">
            <input type="checkbox" id="darkModeSwitch">
            <span class="slider"></span>
           
          </label>
        
        <div class="direitos">
            <h3>Spotlight+</h3>
           <p>Todos os direitos reservados &copy;</p>
          </div>
         
    </nav>
    <main id="main">
@yield('content')
</main>
<footer id="footer">
        
            
            
        <div>
            <h1>Contato</h1>
            <p>(12) 3621-7508</p>
        </div>
        <div id="divp">
            <h1>Localização</h1>
            <p>R. Expedicionário Ernesto Pereira, 260</p>
        </div>
  
        
     
      
</footer>
</body>
<script src="/js/scripts2.js" defer></script>

</html>
