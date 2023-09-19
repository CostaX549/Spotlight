<!DOCTYPE html>
<html lang="pt-BR">
<head>

<!-- PWA  -->
<meta name="theme-color" content="#000000"/>
<link rel="apple-touch-icon" href="{{ asset('corinthians.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>@yield('title')</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/estilo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css">

  

 


</head>
  
  <body  id="body" >
    
    <br>
    

   <header>
        <nav class="navbar navbar-expand-lg" style="background-color: rgb(15,15,15); padding-top: 1px 0;">
        <div class="container">
        
            <a class="navbar-brand text-white" href="/sobrenos">Spotlight+</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                
        
            
                <a href="/">Home
            </a>
        </li>
        @guest
        <li class="nav-item">
                     <a  href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="/register">Cadastrar</a>
                    </li>
        @endguest
            @auth
            <li class="nav-item">
            
            
                <a href="/dashboard">Meus Favoritos
                </a>
            </li>

            <li class="nav-item">
                
        
            
                <a href="/historico">Histórico
            </a>
        </li>
           
            <li class="nav-item">
            
            
            <a href="/user/profile">Meu Perfil
            </a>
        </li>
        <li class="nav-item">
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Sair
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
@endauth
                </ul>
            </div>
            
       
         
        </div>
  
    </nav>
    </header>
    
<main id="main">
@yield('content')
</main>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>

</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous" defer></script>
<script src="/js/scripts.js" defer></script>

</html>
