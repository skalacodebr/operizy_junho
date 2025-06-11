@extends('layouts.admin')

@section('page-title')
    Academy
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Academy</a></li>
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Dashboard</h5>
    </div>
@endsection

@push('css-page')
    <!-- Swiper CSS -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/swiper@9/swiper-bundle.min.css"
    />
    <!-- FontAwesome (ícone de play) -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-p8fX2Bh3XMA1jOjUaLyvPSoi0HT+CzK2U1jjYXYd8y3jEwy+YlZlNE4W3O4j2ed/1wjHHr2Iu+yh3cH+zYx0sg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />

    <style>
    /* ==== Estilos Gerais dos Cards ==== */
    .card-video {
      border-radius: .75rem;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      position: relative;
      transition: transform .3s, box-shadow .3s;
    }
    .card-video:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .card-video img {
      display: block;
      width: 100%;
      height: auto;
    }

    /* ==== Overlay de Play ==== */
    .card-video .play-overlay {
      position: absolute;
      top: 50%; left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2.5rem;
      color: rgba(255,255,255,0.9);
      opacity: 0;
      transition: opacity .3s;
      z-index: 10;
      cursor: pointer;
    }
    .card-video:hover .play-overlay {
      opacity: 1;
    }

    /* ==== Gradiente opcional para legendas ==== */
    .card-video .overlay-gradient {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 40%;
      background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
      pointer-events: none;
    }

    /* ==== Swiper Navigation ==== */
    .swiper-button-next,
    .swiper-button-prev {
      color: #fff;
      width: 3rem;
      height: 3rem;
    }
    .swiper-button-next:hover,
    .swiper-button-prev:hover {
      color: #0d6efd;
    }

    /* ==== Responsividade ==== */
    @media (max-width: 767px) {
      .card-video .play-overlay { font-size: 2rem; }
    }

    /* ==== Estilos Gerais para os Cards de Vídeo ==== */
.card-video {
  border-radius: .75rem;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  position: relative;
  background: #000;
  transition: transform .3s, box-shadow .3s;
}
.card-video:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
.card-video img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.card-video .overlay-gradient {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 40%;
  background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 100%);
  pointer-events: none;
}
.card-video .play-overlay {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%);
  font-size: 2.5rem;
  color: rgba(255,255,255,0.9);
  opacity: 0;
  transition: opacity .3s;
  cursor: pointer;
}
.card-video:hover .play-overlay {
  opacity: 1;
}

/* ==== 1. Vídeos em Destaque (slider) ==== */
.featured-swiper .swiper-wrapper {
  gap: 1rem; /* espaço entre slides */
}
.featured-swiper .swiper-slide {
  width: 360px;       /* largura de cada slide */
}
.featured-swiper .card-video {
  height: 240px;      /* altura fixa dos cards grandes */
}
.featured-swiper .carousel-caption {
  position: absolute;
  bottom: 1rem; left: 1rem; right: 1rem;
  padding: 0;
}
.featured-swiper .carousel-caption h5 {
  font-size: 1.25rem;
  color: #fff;
  margin: 0;
}

/* ==== 2. Grid de “Todos os Vídeos” ==== */
.video-item {
  display: flex;
  justify-content: center;
}
.video-item .card-video {
  height: 160px;      /* altura menor para os cards do grid */
  width: 100%;
}
.video-item .card-body {
  position: absolute;
  bottom: 0; left: 0; right: 0;
  background: rgba(0,0,0,0.6);
  padding: .5rem;
  text-align: center;
}
.video-item .card-body h6 {
  font-size: .9rem;
  color: #fff;
  margin: 0;
}

/* ==== Breakpoints ==== */
@media (max-width: 992px) {
  .featured-swiper .swiper-slide {
    width: 300px;
  }
  .featured-swiper .card-video {
    height: 200px;
  }
  .video-item .card-video {
    height: 140px;
  }
}

@media (max-width: 576px) {
  .featured-swiper .swiper-slide {
    width: 100%;     /* um slide por vez no mobile */
  }
  .featured-swiper .card-video {
    height: 180px;
  }
  .video-item .card-video {
    height: 120px;
  }
}

    </style>
@endpush

@section('content')
<div class="container-fluid">

  <div class="mb-4">
        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#modalCreateCategory">
            <i class="fas fa-folder-plus"></i> Nova Categoria
        </button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUploadVideo">
            <i class="fas fa-video"></i> Enviar Vídeo
        </button>
    </div>

    {{-- ==== 1. Slider de Vídeos em Destaque ==== --}}
<section class="mb-5">
  <h2 class="text-white mb-4">Vídeos em Destaque</h2>
  <div class="swiper featured-swiper">
    <div class="swiper-wrapper">
      @foreach($videos->where('is_featured', 1) as $video)
        <div class="swiper-slide">
          <div class="card-video">
            <img
              src="{{ asset('storage/'.$video->thumbnail_path) }}"
              alt="{{ $video->title }}">
            <div class="overlay-gradient"></div>
            <i
              class="fas fa-play-circle play-overlay"
              data-video="{{ asset('storage/'.$video->video_url) }}">
            </i>
            <div class="carousel-caption d-none d-md-block">
              <h5 class="text-white">{{ $video->title }}</h5>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination mt-3"></div>
  </div>
</section>


    {{-- ==== 2. Grid com Filtro e Vídeos ==== --}}
<section>
  <h2 class="text-white mb-4">Todos os Vídeos</h2>

  {{-- Monta dinamicamente as abas de filtro --}}
  <ul class="nav nav-pills mb-4" id="video-filter">
    <li class="nav-item">
      <button class="nav-link active" data-filter="all">Todos</button>
    </li>
    @foreach($categories as $cat)
      <li class="nav-item">
        <button
          class="nav-link"
          data-filter="{{ Str::slug($cat->name) }}">
          {{ $cat->name }}
        </button>
      </li>
    @endforeach
  </ul>

  <div class="row g-4">
    @foreach($videos as $video)
      <div
        class="col-12 col-sm-6 col-md-4 col-lg-3 video-item"
        data-category="{{ Str::slug($video->category_name) }}">
        <div class="card-video position-relative">
          <img
            src="{{ asset('storage/'.$video->thumbnail_path) }}"
            alt="{{ $video->title }}">
          <i
            class="fas fa-play-circle play-overlay"
            data-video="{{ asset('storage/'.$video->video_url) }}">
          </i>
          <div class="card-body bg-dark text-white text-center">
            <h6 class="mb-0">{{ $video->title }}</h6>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>


    {{-- ==== 3. Modal de Vídeo ==== --}}
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative">
                    <button type="button"
                            class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal"></button>
                    <div class="ratio ratio-16x9">
                        <iframe id="videoFrame"
                                src=""
                                allow="autoplay; encrypted-media"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalCreateCategory" tabindex="-1" aria-labelledby="modalCreateCategoryLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form id="formCreateCategory">
          @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalCreateCategoryLabel">Nova Categoria</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                <label for="category-name" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" id="category-name" name="name" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Salvar Categoria</button>
            </div>
          </div>
        </form>
      </div>
    </div>

{{-- Modal: Upload de Vídeo --}}
<div class="modal fade" id="modalUploadVideo" tabindex="-1" aria-labelledby="modalUploadVideoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formUploadVideo" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalUploadVideoLabel">Enviar Novo Vídeo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="video-title" class="form-label">Título</label>
              <input type="text" class="form-control" id="video-title" name="title" required>
            </div>
            <div class="col-md-6">
              <label for="video-category" class="form-label">Categoria</label>
              <select class="form-select" id="video-category" name="category_id" required>
                <option value="">Selecione...</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-6">
              <label for="video-file" class="form-label">Arquivo de Vídeo</label>
              <input type="file"
                     class="form-control"
                     id="video-file"
                     name="video"
                     accept="video/mp4,video/avi,video/mov"
                     required>
            </div>
            <div class="col-md-6">
              <label for="video-thumbnail" class="form-label">Thumbnail (imagem)</label>
              <input type="file"
                     class="form-control"
                     id="video-thumbnail"
                     name="thumbnail"
                     accept="image/jpeg,image/png,image/webp"
                     required>
            </div>
            <div class="col-md-3">
              <label for="video-featured" class="form-label">Destaque?</label>
              <select class="form-select" id="video-featured" name="is_featured">
                <option value="0" selected>Não</option>
                <option value="1">Sim</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="video-position" class="form-label">Posição</label>
              <input type="number" class="form-control" id="video-position" name="position" value="0">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Enviar Vídeo</button>
        </div>
      </div>
    </form>
  </div>
</div>


</div>
@endsection

@push('script-page')
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
  // configura token CSRF
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(function() {
    // Cria Categoria via AJAX
    $('#formCreateCategory').submit(function(e) {
      e.preventDefault();

      $.ajax({
        url: '{{ route("video-categories.store") }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(res) {
          $('#modalCreateCategory').modal('hide');
          location.reload(); // recarrega a página no sucesso
        },
        error: function(xhr) {
          console.error('Erro ao criar categoria:', xhr.responseJSON || xhr);
          // aqui você pode exibir feedback inline, se quiser
        }
      });
    });

    // Envia Vídeo via AJAX (com Upload)
    $('#formUploadVideo').submit(function(e) {
      e.preventDefault();

      let formData = new FormData(this);
      console.log('FormData entries:', Array.from(formData.entries()));

      $.ajax({
        url: '{{ route("videos.store") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
          $('#modalUploadVideo').modal('hide');
          location.reload(); // recarrega a página no sucesso
        },
        error: function(xhr) {
          console.error('Erro ao enviar vídeo:', xhr.responseJSON || xhr);
          // aqui também você pode mostrar uma mensagem inline, se desejar
        }
      });
    });
  });
</script>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicializa Swiper
        const swiper = new Swiper('.featured-swiper', {
            slidesPerView: 4,
            spaceBetween: 20,
            loop: true,
            navigation: {
              nextEl: '.swiper-button-next',
              prevEl: '.swiper-button-prev',
            },
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            breakpoints: {
              320: { slidesPerView: 1 },
              576: { slidesPerView: 2 },
              768: { slidesPerView: 3 },
              992: { slidesPerView: 4 },
            },
        });

        // Filtro de vídeos
        $('#video-filter .nav-link').click(function(){
            let cat = $(this).data('filter');
            $('#video-filter .nav-link').removeClass('active');
            $(this).addClass('active');
            if(cat === 'all'){
                $('.video-item').show();
            } else {
                $('.video-item').hide();
                $(`.video-item[data-category="${cat}"]`).show();
            }
        });

        // Abrir modal ao clicar no play
        $('.play-overlay').click(function(){
            let url = $(this).data('video') + '?autoplay=1';
            $('#videoFrame').attr('src', url);
            $('#videoModal').modal('show');
        });

        // Limpa src ao fechar
        $('#videoModal').on('hidden.bs.modal', function(){
            $('#videoFrame').attr('src', '');
        });
    });
    </script>
@endpush
