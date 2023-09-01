  $(document).ready(function() {
    const apiKey = '9549bb8a29df2d575e3372639b821bdc';
    const itemsPerPage = 4; // Quantidade de itens por página
    let currentMoviePage = 1;
    let currentSeriesPage = 5;
    let currentDocumentaryPage = 1;

    

    function fetchContent(url, page) {
      const pageUrl = `${url}&page=${page}`;

      return fetch(pageUrl)
        .then(response => response.json())
        .catch(error => {
          console.error('Erro ao obter dados da API:', error);
          return { results: [] };
        });
    }
    

    function displayItems(items, carouselSelector, contentType) {
     
      const carouselInner = $(carouselSelector);
      const carouselItem = $('<div>').addClass('carousel-item');
      if (carouselInner.children().length === 0) {
        carouselItem.addClass('active');
      }
      const row = $('<div>').addClass('row');
      carouselItem.append(row);

      items.forEach(item => {
        const col = $('<div>').addClass('col-md-3');
        const posterPath = item.poster_path;
        const title = item.title || item.name || item.original_title;

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
          .attr('alt', title)
          .addClass('d-block w-100 rounded mb-4')
          .css('cursor', 'pointer');
        // Configurar o evento de clique para cada imagem
     console.log(contentType)
        img.click(function () {
          if (contentType === 'movie') {
            window.location.href = `/filmes/${item.id}`;
          } else if (contentType === 'tv') {
            window.location.href = `/series/${item.id}`;
          } else if (contentType === 'documentary') {
            window.location.href = `/filmes/${item.id}`;
          }
        });
    
        
      
        col.append(img);
      
        row.append(col);
      });

      carouselItem.append(row);
      carouselInner.append(carouselItem);
    }



   

 
  function loadNextPage(apiUrl, page, contentType, carouselSelector, maxPages) {
    if (page > maxPages) {
      return; // Stop loading more pages if the maximum limit is reached
    }
    fetchContent(apiUrl, page)
      .then(data => {
        if (data.results.length > 0) {
          const itemsToDisplay = data.results.slice(0, itemsPerPage);
          displayItems(itemsToDisplay, carouselSelector, contentType);

          if (contentType === 'movie') {
            currentMoviePage++;
          } else if (contentType === 'tv') {
            currentSeriesPage++;
          } else if (contentType === 'documentary') {
            currentDocumentaryPage++;
          }
        }
      });
      
  }
 
  const maxPages = 25; // Set your desired maximum number of pages
  // Carregar a primeira página de filmes
  loadNextPage(
    `https://api.themoviedb.org/3/movie/popular?api_key=${apiKey}&language=pt-BR&certification_country=BR&certification.lte=12`,
    currentMoviePage,
    'movie',
    '#carouselInner',
    maxPages
  );

// Carregar a primeira página de séries populares, ordenadas por popularidade
loadNextPage(
  `https://api.themoviedb.org/3/tv/popular?api_key=${apiKey}&language=pt-BR&sort_by=popularity.desc`,
  currentSeriesPage,
  'tv',
  '#carouselSeriesInner',
  maxPages
);



  // Carregar a primeira página de documentários
  loadNextPage(
    `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&with_genres=99&language=pt-BR&certification_country=BR&certification.lte=12`,
    currentDocumentaryPage,
    'documentary',
    '#carouselDocumentariesInner',
    maxPages
  );

  

  // Configurar o evento de clique para carregar a próxima página quando a seta de avanço for clicada
  $('.carousel-control-next').click(function() {
    loadNextPage(
      `https://api.themoviedb.org/3/movie/popular?api_key=${apiKey}&language=pt-BR&certification_country=BR&certification.lte=12`,
      currentMoviePage,
      'movie',
      '#carouselInner',
      maxPages
    );
    loadNextPage(
      `https://api.themoviedb.org/3/tv/popular?api_key=${apiKey}&language=pt-BR`,
      currentSeriesPage,
      'tv',
      '#carouselSeriesInner',
      maxPages
    );
    loadNextPage(
      `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&with_genres=99&language=pt-BR&certification_country=BR&certification.lte=12`,
      currentDocumentaryPage,
      'documentary',
      '#carouselDocumentariesInner',
      maxPages
    );
  });
 
});
