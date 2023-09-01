
// Varíavel para armazenar os vídeos e imagens de maneira correspondente.
$(document).ready(function() {


const apiKey = '9549bb8a29df2d575e3372639b821bdc';
let currentPage = 1;

function fetchPopularMovies(page) {
  const popularMoviesUrl = `https://api.themoviedb.org/3/movie/popular?api_key=${apiKey}&language=pt-BR&page=${page}`;
  

  fetch(popularMoviesUrl)
    .then(response => response.json())
    .then(data => {
      const carouselInner = $('#carouselInner');
 
      let colCounter = 0;
      let carouselItem = null;

      data.results.forEach((movie, index) => {
        const posterPath = movie.poster_path;
        const title = movie.title;

        if (colCounter === 0) {
          carouselItem = $('<div>').addClass('carousel-item');
          if (index === 0 && page === 1) {
            carouselItem.addClass('active');
          }
          carouselInner.append(carouselItem);

          const row = $('<div>').addClass('row');
          carouselItem.append(row);
        }

        const col = $('<div>').addClass('col-md-3');

        // Adicione um elemento para exibir o título do filme
  

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
                               .attr('alt', title)
                               .addClass('d-block w-100');
        col.append(img);

        // Adicione elementos para exibir as estrelas
        const starContainer = $('<div>').addClass('star-container');

        // Calcula o número de estrelas com base na avaliação (nota do filme)
        const numStars = Math.floor(movie.vote_average / 2);
        for (let i = 0; i < 5; i++) {
          const starIcon = $('<i>').addClass('fas fa-star mt-3 mb-2');
          if (i >= numStars) {
            starIcon.addClass('empty');
          }
          starContainer.append(starIcon);
        }
        col.append(starContainer);

        const row = carouselItem.find('.row').last();
        row.append(col);

        colCounter++;
        if (colCounter === 4) {
          colCounter = 0;
        }

        // Adicione um evento de clique para reproduzir o trailer
        img.click(function () {
          window.scroll(0,0);
          fetch(`https://api.themoviedb.org/3/movie/${movie.id}/videos?api_key=${apiKey}&language=pt-BR`)
            .then(response => response.json())
            .then(videoData => {
              const trailers = videoData.results.filter(video => video.type === 'Trailer');
              if (trailers.length > 0) {
                const trailerKey = trailers[0].key;
                const youtubeEmbedUrl = `https://www.youtube.com/embed/${trailerKey}`;
                
                const videoPlayerDiv = document.getElementById('videoPlayer');
                videoPlayerDiv.innerHTML = `
                  <iframe width="1250" height="800" src="${youtubeEmbedUrl}" frameborder="0" allowfullscreen></iframe>
                  <button id="closeVideoButton" class="close-video-button">&times;</button>
                `;
        
                // Adicione um evento de clique para fechar o vídeo
                $('#closeVideoButton').click(function () {
                  videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
                });
              } else {
                alert('Nenhum trailer disponível para este filme.');
              }
            })
            .catch(error => {
              console.error('Erro ao obter dados do vídeo:', error);
            });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao obter dados da API:', error);
    });
}

function fetchMovies(page, query='') {
  const searchMoviesUrl = `https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&language=pt-BR&page=${page}&query=${query}&certification.lte=14`;
  const carouselInner = $('#carouselInner');
  carouselInner.empty();
  fetch(searchMoviesUrl)
    .then(response => response.json())
    .then(data => {
      const searchResults = data.results;
      const carouselInner = $('#carouselInner');
      if (searchResults.length === 0) {
        const noResultsMessage = $('<p class="text-center">').text('Nenhum resultado encontrado para a pesquisa.');
        carouselInner.append(noResultsMessage);
        return;
      }
      let colCounter = 0;
      let carouselItem = null;
      

      data.results.forEach((movie, index) => {
        const posterPath = movie.poster_path;
        const title = movie.title;

        if (colCounter === 0) {
          carouselItem = $('<div>').addClass('carousel-item');
          if (index === 0 && page === 1) {
            carouselItem.addClass('active');
          }
          carouselInner.append(carouselItem);

          const row = $('<div>').addClass('row');
          carouselItem.append(row);
        }

        const col = $('<div>').addClass('col-md-3');

        // Adicione um elemento para exibir o título do filme
  

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
                               .attr('alt', title)
                               .addClass('d-block w-100');
        col.append(img);

        // Adicione elementos para exibir as estrelas
        const starContainer = $('<div>').addClass('star-container');

        // Calcula o número de estrelas com base na avaliação (nota do filme)
        const numStars = Math.floor(movie.vote_average / 2);
        for (let i = 0; i < 5; i++) {
          const starIcon = $('<i>').addClass('fas fa-star mt-3 mb-2');
          if (i >= numStars) {
            starIcon.addClass('empty');
          }
          starContainer.append(starIcon);
        }
        col.append(starContainer);

        const row = carouselItem.find('.row').last();
        row.append(col);

        colCounter++;
        if (colCounter === 4) {
          colCounter = 0;
        }

        // Adicione um evento de clique para reproduzir o trailer
        img.click(function () {
          window.scroll(0,0);
          fetch(`https://api.themoviedb.org/3/movie/${movie.id}/videos?api_key=${apiKey}&language=pt-BR`)
            .then(response => response.json())
            .then(videoData => {
              const trailers = videoData.results.filter(video => video.type === 'Trailer');
              if (trailers.length > 0) {
                const trailerKey = trailers[0].key;
                const youtubeEmbedUrl = `https://www.youtube.com/embed/${trailerKey}`;
                
                const videoPlayerDiv = document.getElementById('videoPlayer');
                videoPlayerDiv.innerHTML = `
                  <iframe width="1250" height="800" src="${youtubeEmbedUrl}" frameborder="0" allowfullscreen></iframe>
                  <button id="closeVideoButton" class="close-video-button">&times;</button>
                `;
        
                // Adicione um evento de clique para fechar o vídeo
                $('#closeVideoButton').click(function () {
                  videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
                });
              } else {
                alert('Nenhum trailer disponível para este filme.');
              }
            })
            .catch(error => {
              console.error('Erro ao obter dados do vídeo:', error);
            });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao obter dados da API:', error);
    });
}



const carouselInner = $('#carouselInner');

$('#myCarouselThree').on('slid.bs.carousel', function () {
  if (carouselInner.children().length - 1 === $('#myCarouselThree .active').index()) {
    currentPage++;
    fetchPopularMovies(currentPage);
  }
});


const backToPopularButton = $('#backToPopularButton');

backToPopularButton.click(function() {
  fetchPopularMovies(1);
  carouselInner.empty();
});




let currentSeriesPage = 8; // Começar a busca a partir da página 2

function fetchSeries(page) {
  const seriesUrl = `https://api.themoviedb.org/3/tv/popular?api_key=${apiKey}&language=pt-BR&page=${page}&certification_country=BR`;

  fetch(seriesUrl)
    .then(response => response.json())
    .then(data => {
      const carouselSeriesInner = $('#carouselSeriesInner');

      let colCounter = 0;
      let carouselItem = null;

      data.results.forEach((serie, index) => {
        const posterPath = serie.poster_path;
        const title = serie.name;
        const isAdult = serie.adult; // Verifica se a série é para adultos

        // Verificar se a série é para adultos
        if (isAdult) {
          // Não adicionar esta série ao carrossel
          return; // Pular para a próxima iteração do loop
        }

        if (colCounter === 0) {
          carouselItem = $('<div>').addClass('carousel-item');
          if (index === 0 && page === 8) { // Verifique se a página é 2 para adicionar a classe "active"
            carouselItem.addClass('active');
          }
          carouselSeriesInner.append(carouselItem);

          const row = $('<div>').addClass('row');
          carouselItem.append(row);
        }

        const col = $('<div>').addClass('col-md-3');

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
          .attr('alt', title)
          .addClass('d-block w-100')
          .css('cursor', 'pointer'); // Adicione um cursor de apontar
        col.append(img);

        // Adicione elementos para exibir as estrelas
        const starContainer = $('<div>').addClass('star-container');

        // Calcula o número de estrelas com base na avaliação (nota do filme)
        const numStars = Math.floor(serie.vote_average / 2);
        for (let i = 0; i < 5; i++) {
          const starIcon = $('<i>').addClass('fas fa-star mt-3 mb-2');
          if (i >= numStars) {
            starIcon.addClass('empty');
          }
          starContainer.append(starIcon);
        }
        
        col.append(starContainer);
        
        const row = carouselItem.find('.row').last();
        row.append(col);

        colCounter++;
        if (colCounter === 4) {
          colCounter = 0;
        }

        // Adicione um evento de clique para reproduzir o trailer da série
        img.click(function () {
          window.scroll(0,0);
          fetch(`https://api.themoviedb.org/3/tv/${serie.id}/videos?api_key=${apiKey}&language=pt-BR`)
            .then(response => response.json())
            .then(videoData => {
              const trailers = videoData.results.filter(video => video.type === 'Trailer');
              if (trailers.length > 0) {
                const trailerKey = trailers[0].key;
                const youtubeEmbedUrl = `https://www.youtube.com/embed/${trailerKey}`;
                const videoPlayerDiv = document.getElementById('videoPlayer');
                videoPlayerDiv.innerHTML = `
                  <iframe width="1250" height="800" src="${youtubeEmbedUrl}" frameborder="0" allowfullscreen></iframe>
                  <button id="closeVideoButton" class="close-video-button">&times;</button>
                `;
        
                // Adicione um evento de clique para fechar o vídeo
                $('#closeVideoButton').click(function () {
                  videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
                });
              } else {
                // Se não houver trailers do tipo "Trailer", tente carregar outros trailers
                fetch(`https://api.themoviedb.org/3/tv/${serie.id}/videos?api_key=${apiKey}`)
                  .then(response => response.json())
                  .then(videoData => {
                    const trailers2 = videoData.results.filter(video => video.type === 'Trailer');
                    if (trailers2.length > 0) {
                      const trailerKey2 = trailers2[0].key;
                      const youtubeEmbedUrl2 = `https://www.youtube.com/embed/${trailerKey2}`;
                      const videoPlayerDiv = document.getElementById('videoPlayer');
                      videoPlayerDiv.innerHTML = `
                        <iframe width="1250" height="800" src="${youtubeEmbedUrl2}" frameborder="0" allowfullscreen></iframe>
                        <button id="closeVideoButton" class="close-video-button">&times;</button>
                      `;
        
                      // Adicione um evento de clique para fechar o vídeo
                      $('#closeVideoButton').click(function () {
                        videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
                      });
                    } else {
                      alert('Nenhum trailer disponível para esta série.');
                    }
                  })
                  .catch(error => {
                    console.error('Erro ao obter dados do vídeo:', error);
                  });
              }
            })
            .catch(error => {
              console.error('Erro ao obter dados do vídeo:', error);
            });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao obter dados da API:', error);
    });
}
const backToPopularButtonSeries = $('#backToPopularButtonSeries');
const carouselSeriesInner = $('#carouselSeriesInner');
backToPopularButtonSeries.click(function() {
  fetchSeries(8);
  carouselSeriesInner.empty();
});

function fetchSeriesByQuery(page, query='') {
  const seriesSearchUrl = `https://api.themoviedb.org/3/search/tv?api_key=${apiKey}&language=pt-BR&query=${query}`;

  fetch(seriesSearchUrl)
    .then(response => response.json())
    .then(data => {
      const searchResults = data.results;

      // Limpar o carrossel antes de adicionar os resultados da pesquisa
      const carouselSeriesInner = $('#carouselSeriesInner');
      carouselSeriesInner.empty();

      // Verificar se há resultados na pesquisa
      if (searchResults.length === 0) {
        const noResultsMessage = $('<p class="text-center">').text('Nenhum resultado encontrado para a pesquisa.');
        carouselSeriesInner.append(noResultsMessage);
        return;
      }

      let colCounter = 0;
      let carouselItem = null;

      searchResults.forEach((serie, index) => {
        const posterPath = serie.poster_path;
        const title = serie.name;

        if (colCounter === 0) {
          carouselItem = $('<div>').addClass('carousel-item');
          if (index === 0) { // Definir o primeiro item como ativo
            carouselItem.addClass('active');
          }
          carouselSeriesInner.append(carouselItem);

          const row = $('<div>').addClass('row');
          carouselItem.append(row);
        }

        const col = $('<div>').addClass('col-md-3');

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
          .attr('alt', title)
          .addClass('d-block w-100')
          .css('cursor', 'pointer'); // Adicionar um cursor de apontar
        col.append(img);

        // Adicionar elementos para exibir as estrelas (opcional)
        const starContainer = $('<div>').addClass('star-container');
        // Adicione elementos para exibir as estrelas


        // Calcula o número de estrelas com base na avaliação (nota do filme)
        const numStars = Math.floor(serie.vote_average / 2);
        for (let i = 0; i < 5; i++) {
          const starIcon = $('<i>').addClass('fas fa-star mt-3 mb-2');
          if (i >= numStars) {
            starIcon.addClass('empty');
          }
          starContainer.append(starIcon);
        }
        col.append(starContainer);

        const row = carouselItem.find('.row').last();
        row.append(col);

        colCounter++;
        if (colCounter === 4) {
          colCounter = 0;
        }

        // Adicionar evento de clique para reproduzir o trailer da série
        img.click(function () {
          window.scroll(0,0);
          fetch(`https://api.themoviedb.org/3/tv/${serie.id}/videos?api_key=${apiKey}&language=pt-BR`)
            .then(response => response.json())
            .then(videoData => {
              const trailers = videoData.results.filter(video => video.type === 'Trailer');
              if (trailers.length > 0) {
                const trailerKey = trailers[0].key;
                const youtubeEmbedUrl = `https://www.youtube.com/embed/${trailerKey}`;
                const videoPlayerDiv = document.getElementById('videoPlayer');
                videoPlayerDiv.innerHTML = `
                  <iframe width="1250" height="800" src="${youtubeEmbedUrl}" frameborder="0" allowfullscreen></iframe>
                  <button id="closeVideoButton" class="close-video-button">&times;</button>
                `;
        
                // Adicione um evento de clique para fechar o vídeo
                $('#closeVideoButton').click(function () {
                  videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
                });
              } else {
                // Se não houver trailers do tipo "Trailer", tente carregar outros trailers
                fetch(`https://api.themoviedb.org/3/tv/${serie.id}/videos?api_key=${apiKey}`)
                  .then(response => response.json())
                  .then(videoData => {
                    const trailers2 = videoData.results.filter(video => video.type === 'Trailer');
                    if (trailers2.length > 0) {
                      const trailerKey2 = trailers2[0].key;
                      const youtubeEmbedUrl2 = `https://www.youtube.com/embed/${trailerKey2}`;
                      const videoPlayerDiv = document.getElementById('videoPlayer');
                      videoPlayerDiv.innerHTML = `
                        <iframe width="1250" height="800" src="${youtubeEmbedUrl2}" frameborder="0" allowfullscreen></iframe>
                        <button id="closeVideoButton" class="close-video-button">&times;</button>
                      `;
        
                      // Adicione um evento de clique para fechar o vídeo
                      $('#closeVideoButton').click(function () {
                        videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
                      });
                    } else {
                      alert('Nenhum trailer disponível para esta série.');
                    }
                  })
                  .catch(error => {
                    console.error('Erro ao obter dados do vídeo:', error);
                  });
              }
            })
            .catch(error => {
              console.error('Erro ao obter dados do vídeo:', error);
            });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao obter dados da API:', error);
    });
}
    




$(document).ready(function () {
  const carouselSeriesInner = $('#carouselSeriesInner');

  $('#myCarouselSeries').on('slid.bs.carousel', function () {
    if (carouselSeriesInner.children().length - 1 === $('#myCarouselSeries .active').index()) {
      currentSeriesPage++;
      fetchSeries(currentSeriesPage);
    }
  });

  fetchSeries(currentSeriesPage); // Busca as séries da página inicial (página 2)
});


let currentDocumentariesPage = 1;

function fetchDocumentaries(page) {
  const documentariesUrl = `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&with_genres=99&language=pt-BR&page=${page}&certification_country=BR&certification.lte=14`;

  fetch(documentariesUrl)
    .then(response => response.json())
    .then(data => {
   
 

      let colCounter = 0;
      let carouselItem = null;

      data.results.forEach((documentary, index) => {
        const posterPath = documentary.poster_path;
        const title = documentary.title;

        if (colCounter === 0) {
          carouselItem = $('<div>').addClass('carousel-item');
          if (index === 0 && page === 1) {
            carouselItem.addClass('active');
          }
          carouselDocumentariesInner.append(carouselItem);

          const row = $('<div>').addClass('row');
          carouselItem.append(row);
        }

        const col = $('<div>').addClass('col-md-3');
        

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
                               .attr('alt', title)
                               .addClass('d-block w-100')
                               .css('cursor', 'pointer'); // Adicione um cursor de apontar
        col.append(img);
     // Adicione elementos para exibir as estrelas
     const starContainer = $('<div>').addClass('star-container');

     // Calcula o número de estrelas com base na avaliação (nota do filme)
     const numStars = Math.floor(documentary.vote_average / 2);
     for (let i = 0; i < 5; i++) {
       const starIcon = $('<i>').addClass('fas fa-star mt-3 mb-2');
       if (i >= numStars) {
         starIcon.addClass('empty');
       }
       starContainer.append(starIcon);
     }
     col.append(starContainer);
        const row = carouselItem.find('.row').last();
        row.append(col);

        colCounter++;
        if (colCounter === 4) {
          colCounter = 0;
        }

        // Adicione um evento de clique para reproduzir o trailer do documentário
        img.click(function () {
          window.scroll(0,0);
          fetch(`https://api.themoviedb.org/3/movie/${documentary.id}/videos?api_key=${apiKey}`)
            .then(response => response.json())
            .then(videoData => {
              const trailers = videoData.results.filter(video => video.type === 'Trailer');
              if (trailers.length > 0) {
                const trailerKey = trailers[0].key;
                const youtubeEmbedUrl = `https://www.youtube.com/embed/${trailerKey}`;
                
                const videoPlayerDiv = document.getElementById('videoPlayer');
                videoPlayerDiv.innerHTML = `
                <iframe width="1250" height="800" src="${youtubeEmbedUrl}" frameborder="0" allowfullscreen></iframe>
                <button id="closeVideoButton" class="close-video-button">&times;</button>
              `;
              $('#closeVideoButton').click(function () {
                videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
              });
              } else {
                alert('Nenhum trailer disponível para este filme.');
              }
            })
            .catch(error => {
              console.error('Erro ao obter dados do vídeo:', error);
            });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao obter dados da API:', error);
    });
}
const backToPopularButtonDocumentaries = $('#backToPopularButtonDocumentaries');

backToPopularButtonDocumentaries.click(function() {
  fetchDocumentaries(1);
  carouselDocumentariesInner.empty();
});

function fetchDocumentariesByQuery(page,query='') {
  const documentariesUrl = `https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&with_genres=99&language=pt-BR&page=${page}&certification_country=BR&certification.lte=14&query=${query}`;
  const carouselDocumentariesInner = $('#carouselDocumentariesInner');
  carouselDocumentariesInner.empty();
  fetch(documentariesUrl)
    .then(response => response.json())
    .then(data => {
    
      let colCounter = 0;
      let carouselItem = null;

      data.results.forEach((documentary, index) => {
        const posterPath = documentary.poster_path;
        const title = documentary.title;

        if (colCounter === 0) {
          carouselItem = $('<div>').addClass('carousel-item');
          if (index === 0 && page === 1) {
            carouselItem.addClass('active');
          }
          carouselDocumentariesInner.append(carouselItem);

          const row = $('<div>').addClass('row');
          carouselItem.append(row);
        }

        const col = $('<div>').addClass('col-md-3');
        

        const img = $('<img>').attr('src', `https://image.tmdb.org/t/p/w500/${posterPath}`)
                               .attr('alt', title)
                               .addClass('d-block w-100')
                               .css('cursor', 'pointer'); // Adicione um cursor de apontar
        col.append(img);
     // Adicione elementos para exibir as estrelas
     const starContainer = $('<div>').addClass('star-container');

     // Calcula o número de estrelas com base na avaliação (nota do filme)
     const numStars = Math.floor(documentary.vote_average / 2);
     for (let i = 0; i < 5; i++) {
       const starIcon = $('<i>').addClass('fas fa-star mt-3 mb-2');
       if (i >= numStars) {
         starIcon.addClass('empty');
       }
       starContainer.append(starIcon);
     }
     col.append(starContainer);
        const row = carouselItem.find('.row').last();
        row.append(col);

        colCounter++;
        if (colCounter === 4) {
          colCounter = 0;
        }

        // Adicione um evento de clique para reproduzir o trailer do documentário
        img.click(function () {
          window.scroll(0,0);
          fetch(`https://api.themoviedb.org/3/movie/${documentary.id}/videos?api_key=${apiKey}`)
            .then(response => response.json())
            .then(videoData => {
              const trailers = videoData.results.filter(video => video.type === 'Trailer');
              if (trailers.length > 0) {
                const trailerKey = trailers[0].key;
                const youtubeEmbedUrl = `https://www.youtube.com/embed/${trailerKey}`;
                
                const videoPlayerDiv = document.getElementById('videoPlayer');
                videoPlayerDiv.innerHTML = `
                <iframe width="1250" height="800" src="${youtubeEmbedUrl}" frameborder="0" allowfullscreen></iframe>
                <button id="closeVideoButton" class="close-video-button">&times;</button>
              `;
              $('#closeVideoButton').click(function () {
                videoPlayerDiv.innerHTML = ''; // Limpar o conteúdo do vídeo
              });
              } else {
                alert('Nenhum trailer disponível para este filme.');
              }
            })
            .catch(error => {
              console.error('Erro ao obter dados do vídeo:', error);
            });
        });
      });
    })
    .catch(error => {
      console.error('Erro ao obter dados da API:', error);
    });
}

  const carouselDocumentariesInner = $('#carouselDocumentariesInner');

  $('#myCarouselDocumentaries').on('slid.bs.carousel', function () {
    if (carouselDocumentariesInner.children().length - 1 === $('#myCarouselDocumentaries .active').index()) {
      currentDocumentariesPage++;
      fetchDocumentaries(currentDocumentariesPage);
    }
  });

  fetchDocumentaries(currentDocumentariesPage); // Busca os documentários da primeira página
 

  
  fetchPopularMovies(currentPage); // Busca os filmes da primeira página
  

   // Adicione um evento de clique para o botão de pesquisa
   $('#searchButton').click(function() {
    const searchTerm = $('#searchInput').val().trim();
    const searchType = $('#searchType').val(); // Obter o valor selecionado no menu suspenso
    if (searchTerm) {
      if (searchType === 'tv') { // Verificar se o tipo de pesquisa é "Séries"
         currentPage = 1;
        fetchSeriesByQuery(currentPage,searchTerm); // Chamar a função para buscar séries
      } else if (searchType === 'movie') { 
        currentPage = 1;
        fetchMovies(currentPage, searchTerm);
      } else if (searchType === 'documentary') {
        fetchDocumentariesByQuery(currentPage, searchTerm);
        currentPage = 1;
      }
    }
  });
    
  

  currentPage = 1;
  fetchMovies(currentPage, searchTerm);
  
    var prevButton = $('.carousel-control-prev');
    if (fetchMovies(1)) {
      prevButton.hide();
    } else {
      prevButton.show();
    }


  // Adicione um evento para pressionar Enter no campo de pesquisa
  $('#searchInput').keypress(function(event) {
    if (event.which === 13) { // Código de tecla Enter
      const searchTerm = $(this).val().trim();
      if (searchTerm) {
        currentPage = 1;
        fetchMovies(currentPage, searchTerm);
      }
    }
  });


});


$(document).ready(function() {
  const menu = $('#menu');
  const nav = $('#navbar');
  const li = $('li');
  const elementById = $('#main');
  const childElements = elementById.find('img');
  const video =  $('#videoPlayer')
  const header = $('#header');
  const main = $('#main');
  const footer = $('#footer');
  const body = $('body');


 


  function addOverlay() {
    const overlay = $('<div></div>').addClass('overlay-div').css({
      'position': 'fixed',
      'top': 0,
      'left': 0,
      'width': '100%',
      'height': '100%',
      'background-color': 'rgba(0, 0, 0, 0.5)',

    });
  
    if ($('.overlay-div').length === 0) {
      $('body > div:not(#navbar):not(header):not(#video-overlay)').append(overlay);
      $('div:not(#navbar):not(header div) img').addClass('no-hover-transform');
      
    }
  
    // Desabilitar as funções do site enquanto o overlay estiver ativo
    $('div:not(#navbar):not(header div)').addClass('no-functions');
    
  }
  
  
  
  // Remove overlay
  function removeOverlay() {
    $('.overlay-div').remove();
    $('div:not(#navbar):not(header div) img').removeClass('no-hover-transform');
    $('div:not(#navbar):not(header div)').removeClass('no-functions');


  }

  // Adicionar hover apenas quando o overlay não estiver ativo



 

  // Adiciona um ouvinte de evento para o clique do menu hamburguer
  menu.on('click', function() {
    // Verifica se a navbar possui a classe hide
    if (nav.hasClass('hide')) {
      // Mostra a navbar(menu)
      addOverlay();
      nav.addClass('show');
      nav.removeClass('hide');
      main.css('opacity', '0.5');
      footer.css('opacity', '0.5');
      header.css('opacity', '0.5');
      body.addClass('overflow-hidden');
      body.removeClass('overflow-auto');
      video[0].pause();
      childElements.off('mouseenter mouseleave').css('transform', '');
    }
  });
  
  // Adiciona um ouvinte de evento para o clique no documento
  $(document).on('click', function(event) {
    const isClickInsideMenu = nav.is(event.target) || menu.is(event.target);
    const isClickInsideNavbar = nav.has(event.target).length > 0;
  
    // Verifica se o clique ocorreu dentro do menu ou no ícone do menu hamburguer
    if (!isClickInsideMenu && nav.hasClass('show') && !isClickInsideNavbar) {
      // Esconde o menu
      nav.removeClass('show');
      nav.addClass('hide');
      main.css('opacity', '');
      footer.css('opacity', '');
      body.removeClass('no-scroll');
      header.css('opacity', '');
      body.removeClass('overflow-hidden');
      body.toggleClass('overflow-alternative');
      removeOverlay();
    }
  });
  
  
  function active() {
    if (nav.hasClass('show')) {
      // Esconde a navbar
      removeOverlay();
      nav.removeClass('show');
      nav.addClass('hide');
      main.css('opacity', '');
      footer.css('opacity', '');
      body.removeClass('no-scroll');
      header.css('opacity', '');
      body.removeClass('overflow-hidden');
      body.toggleClass('overflow-alternative');
    }
  }

  $(document).ready(function() {
    $("li a").on("click", function(event) {
      // Prevenir o comportamento padrão do clique
      event.preventDefault();
    
      // Obter o destino do link
      var page = $(this).attr('href');
    
      // Aguardar 500ms antes de redirecionar
      setTimeout(function() {
        // Redirecionar para a página desejada
        window.location.href = page;
      }, 500);
    });
  });
  
  // Verifica cada item da navbar
  li.each(function() {
    // Adiciona um ouvinte de evento para o clique de cada item da navbar
    $(this).on('click', active);
  });
});

