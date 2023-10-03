<!DOCTYPE html>
<html lang="pt-BR">
<head>
  
  <link rel="icon" href="Ícone Spotlight+.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- PWA  -->
<meta name="theme-color" content="#6777ef"/>
<link rel="apple-touch-icon" href="{{ asset('corinthians.png') }}">
<link rel="manifest" href="{{ asset('manifest.json') }}">
   
    <title>@yield('title')</title>
   
    
    <link rel="stylesheet" href="/css/login.css">



  

    @livewireStyles


</head>
<header class="mt-2 mb-2" id="header">
  <div  id="menu">
          <div class="linha"></div>
          <div class="linha"></div> 
          <div class="linha"></div>
      </div>
</header>
  <body  id="body" >
    
    <br>
    

   
  
<main id="main">
@yield('content')
</main>
</body>
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }

    
</script>
@livewireScripts 
</html>
