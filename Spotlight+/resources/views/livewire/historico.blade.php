<div>
    @extends('layouts.main')

    @section('title', 'Histórico')
    
    @section('content')
    @guest
    <div class="container text-center">
        <div class="text-center text-white">
            <i class="ri-time-fill ri-lg"></i> <!-- Ícone de relógio Remix Icon -->
        </div>
        <h1 class="text-center text-white mt-3">Controle o que você vê</h1>
        <p class="text-center text-white mt-3">O histórico de exibição não é visível quando você está desconectado.</p>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="btn btn-primary">Fazer login</a>
        </div>
    </div>
    @endguest
    @auth
    
    <a href="javascript:history.back()" class="back-link text-primary">
        <i class="ri-arrow-left-line ri-lg arrow-icon"></i>
    </a>
    <div id="teste" class="container mb-1">
        <div class="row align-items-center">
            <div class="col">
                @if (!empty($mediaComDetalhes))
                    <p class="h3 text-white mb-0 d-inline" id="dinamicText">Histórico: {{ $mediaComDetalhes[0]['data_visualizacao']->format('d/m/Y') }}</p>
                    <button id="botaoExcluirFilmes" class="btn btn-danger float-end">
        <i class="fas fa-trash"></i> 
    </button>
                @else
                    <p class="h3 text-white mb-0 d-inline">Histórico</p>
                @endif
            </div>
        </div>
    </div>
    @if (empty($mediaComDetalhes))
    <div class="row" style="margin-left: 295px; margin-top: 10px;">
        <h5 class="text-white">Você não possui filmes ou séries no histórico.</h5>
        <a href="/">Veja novos filmes e séries</a>
    </div>
    @else
    
    <form method="POST" action="{{ route('historico.removerSelecionados') }}" id="removerItensForm">
        @csrf
        @method('DELETE')
    
        <div class="container">
            
            <div class="row" id="movieContainer">
                @foreach($mediaComDetalhes as $media)
                <div class="col-6 col-md-3 mb-4" data-media-id="{{ $media['media_id'] }}">
                @if ($media['media_type'] === 'filme')
            <a href="{{ route('filmes.show', ['filmeId' => $media['media_id']]) }}">
            @elseif ($media['media_type'] === 'serie')
            <a href="{{ route('series.show', ['serieId' => $media['media_id']]) }}">
              @endif
                  
                        <img src="https://image.tmdb.org/t/p/original{{ $media['poster_path'] }}" class="img-fluid rounded" loading="lazy" alt="{{ $media['title'] }}">
                        </a>
                  
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-danger" id="removerItensSelecionados" style="display: none;">Remover Itens Selecionados</button>
        </div>
    </form>
    </div> 
        </div>
    </div>
    
    <div class="container">
    
    
      
    @endif
    @endauth
    
    <div class="d-flex justify-content-center">
        {{ $historico->links('vendor.pagination.bootstrap-5') }}
    </div>
    
    @endsection
    
</div>
