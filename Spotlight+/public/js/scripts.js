$(document).ready(function () {
   
  
  $("#filmeCarousel").owlCarousel({
    items: 4, // Número de itens a serem exibidos
    loop: true, // Loop infinito
    margin: 15, // Espaçamento entre os iten
    nav: true, // Para habilitar os controles de navegação
    responsiveClass: true,
    responsive: {
      0: {
        items: 2 // Número de itens a serem exibidos em telas menores
      },
      576: {
        items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
      },
      768: {
        items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
      },
      992: {
        items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
      }
    }
  });

  $("#myCarouselMovies").owlCarousel({
    items: 4, // Número de itens a serem exibidos
    loop: true, // Loop infinito
    margin: 15, // Espaçamento entre os itens
    
    responsiveClass: true,
    responsive: {
        0: {
            items: 2 // Número de itens a serem exibidos em telas menores
        },
        576: {
            items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
        },
        768: {
            items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
        },
        992: {
            items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
        }
    }
});

$("#myCarouselThree").owlCarousel({
  items: 4, // Número de itens a serem exibidos
  loop: true, // Loop infinito
  margin: 15, // Espaçamento entre os itens


  responsiveClass: true,
  responsive: {
      0: {
          items: 2 // Número de itens a serem exibidos em telas menores
      },
      576: {
          items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
      },
      768: {
          items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
      },
      992: {
          items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
      }
  }
});
$("#favoriteCarousel").owlCarousel({
    items: 4, // Número de itens a serem exibidos
    loop: true, // Loop infinito
    margin: 15, // Espaçamento entre os itens
   
    responsiveClass: true,
    responsive: {
        0: {
            items: 2 // Número de itens a serem exibidos em telas menores
        },
        576: {
            items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
        },
        768: {
            items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
        },
        992: {
            items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
        }
    }
  });
  

$("#myCarouselSeries").owlCarousel({
  items: 4, // Número de itens a serem exibidos
  loop: true, // Loop infinito
  margin: 15, // Espaçamento entre os itens
  responsiveClass: true,
  responsive: {
      0: {
          items: 2 // Número de itens a serem exibidos em telas menores
      },
      576: {
          items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
      },
      768: {
          items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
      },
      992: {
          items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
      }
  }
});

$("#myCarouselDocumentaries").owlCarousel({
  items: 4, // Número de itens a serem exibidos
  loop: true, // Loop infinito
  margin: 15, // Espaçamento entre os itens
  responsiveClass: true,
  responsive: {
      0: {
          items: 2 // Número de itens a serem exibidos em telas menores
      },
      576: {
          items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
      },
      768: {
          items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
      },
      992: {
          items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
      }
  }
});

$("#myAnimeCarousel").owlCarousel({
    items: 4, // Número de itens a serem exibidos
    loop: true, // Loop infinito
    margin: 15, // Espaçamento entre os itens
    responsiveClass: true,
    responsive: {
        0: {
            items: 2 // Número de itens a serem exibidos em telas menores
        },
        576: {
            items: 2 // Número de itens a serem exibidos em telas de 576px de largura ou mais
        },
        768: {
            items: 3 // Número de itens a serem exibidos em telas de 768px de largura ou mais
        },
        992: {
            items: 4 // Número de itens a serem exibidos em telas de 992px de largura ou mais
        }
    }
  });


  let botaoClicado = false;

  // Evento de clique no botão
  $('#botaoExcluirFilmes').on('click', function() {
    const botao = $(this);
  
    if (botaoClicado) {
      // Se já foi clicado, transforme-o novamente em ícone de lixeira
      botao.find('i').removeClass('fa-times').addClass('fa-trash');
    } else {
      // Se não foi clicado, transforme-o em ícone de "X"
      botao.find('i').removeClass('fa-trash').addClass('fa-times');
    }
  
    botao.toggleClass('clicked'); // Adiciona/remova uma classe para acionar a transição CSS
    botaoClicado = !botaoClicado; // Alterne o estado do botão
  });

});


const filmesSelecionados = [];
let modoSelecaoAtivado = false; // Variável de controle

// Função para adicionar ou remover um filme da seleção
function toggleSelecao(id) {
    const index = filmesSelecionados.indexOf(id);
    if (index === -1) {
        filmesSelecionados.push(id);
    } else {
        filmesSelecionados.splice(index, 1);
    }
}
    
// Função para atualizar a classe CSS do filme selecionado
function atualizarEstilo(id) {
    const elemento = $(`[data-media-id="${id}"]`);
    if (elemento.length) {
        elemento.toggleClass('selecionado');
    }
}

// Evento de clique em um filme (apenas quando o modo de seleção estiver ativado)
$(document).on('click', '.col-6', function() {
    
    if (modoSelecaoAtivado) { // Verifique se o modo de seleção está ativado
        event.preventDefault(); // Evita a navegação padrão
        const id = $(this).data('media-id');
        toggleSelecao(id);
        atualizarEstilo(id);
    }
});
var textoOriginal = $('#dinamicText').text();
// Evento de clique no botão "Excluir Filmes"
$('#botaoExcluirFilmes').on('click', function() {
    modoSelecaoAtivado = !modoSelecaoAtivado; // Alterne o modo de seleção ao clicar no botão

    if (modoSelecaoAtivado) {
        console.log('Modo de seleção ativado. Clique nos filmes para selecionar.');
        $('#instruction').show();
        $('#removerItensSelecionados').show();
        $('#dinamicText').css('opacity', '0'); // Define a opacidade para 0
        setTimeout(function() {
            $('#dinamicText').text('Selecione o que deseja excluir.');
            $('#dinamicText').css('opacity', '1'); // Define a opacidade de volta para 1
        }, 300); // Espera 300 milissegundos (0.3 segundos) antes de atualizar o texto
    } else {
        console.log('Modo de seleção desativado. Clique nos posters para ver os filmes.');
        $('#instruction').hide();
        $('#removerItensSelecionados').hide();
        $('#dinamicText').css('opacity', '0'); // Define a opacidade para 0
        setTimeout(function() {
            $('#dinamicText').text(textoOriginal);
            $('#dinamicText').css('opacity', '1'); // Define a opacidade de volta para 1
        }, 300); // Espera 300 milissegundos (0.3 segundos) antes de atualizar o texto

        filmesSelecionados.forEach(id => {
            atualizarEstilo(id);
        });
        filmesSelecionados.length = 0;
    }

    $(this).toggleClass('modo-selecao-ativado', modoSelecaoAtivado);
});

// Evento de clique no botão "Remover Itens Selecionados"
$('#removerItensSelecionados').on('click', function() {
    // Certifique-se de que há itens selecionados para remover
    if (filmesSelecionados.length > 0) {
        // Adicione os IDs selecionados ao formulário
        const form = $('#removerItensForm');
        filmesSelecionados.forEach(id => {
            form.append(`<input type="hidden" name="itens_selecionados[]" value="${id}">`);
        });

        // Envie o formulário para o servidor
        form.submit();
    } else {
        console.log('Nenhum item selecionado para remover.');
    }

   
});




