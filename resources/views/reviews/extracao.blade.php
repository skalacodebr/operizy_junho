@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Importar avaliação</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Importar avaliação</h5>
    </div>
@endsection

@section('content')
<style>
  /* progress wizard */
  .progress-steps {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    margin-bottom: 1.5rem;
  }
  .progress-steps .circle {
    width: 1.5rem; height: 1.5rem; border-radius: 50%;
    border: 2px solid #ccc; display: flex; align-items: center;
    justify-content: center; background:#fff; color:#666;
  }
  .progress-steps .circle.active {
    border-color: #fb6c2b; background:#fb6c2b; color:#fff;
  }
  .progress-steps .line {
    flex:1; height:2px; background:#ccc;
  }

  /* source cards */
  .source-card {
    width:80px; height:80px; border:2px solid #ddd;
    border-radius:.5rem; display:flex; align-items:center;
    justify-content:center; cursor:pointer; transition:border-color .2s;
  }
  .source-card.selected {
    border-color:#fb6c2b; background:#ffece2;
  }

  /* star rating */
  .star-rating i { font-size:1.5rem; margin-right:2px; }

  /* review cards */
  .review-card.selected { border:2px solid #28a745; }
</style>

<div class="container-fluid mt-4">
  <!-- tabs -->
  <ul class="nav nav-tabs mb-4">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#import">Importar avaliação</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#created">Avaliações criadas</a>
    </li>
  </ul>

  <div class="tab-content">
    <!-- Importar avaliação -->
    <div class="tab-pane fade show active" id="import">
      <div class="mx-auto">
        <!-- progress -->
        <div class="progress-steps">
          <div class="circle active" data-step="1">1</div><div class="line"></div>
          <div class="circle" data-step="2">2</div><div class="line"></div>
          <div class="circle" data-step="3">3</div><div class="line"></div>
          <div class="circle" data-step="4">4</div><div class="line"></div>
          <div class="circle" data-step="5">5</div>
        </div>

        <!-- STEP 1 -->
        <div id="step1">
          <div class="d-flex justify-content-center mb-4 flex-gap">
          <div class="source-card" data-source="Shein">
                <img src="{{ asset('assets/images/shein.png') }}" alt="Shein" style="max-width: 80%; max-height: 80%;">
            </div>
            <div class="source-card" data-source="Shopee">
                <img src="{{ asset('assets/images/shoppe.png') }}" alt="Shopee" style="max-width: 80%; max-height: 80%;">
            </div>
            <div class="source-card" data-source="AliExpress">
                <img src="{{ asset('assets/images/ali.png') }}" alt="AliExpress" style="max-width: 80%; max-height: 80%;">
            </div>
            <div class="source-card" data-source="Temu">
                <img src="{{ asset('assets/images/temu.png') }}" alt="Temu" style="max-width: 80%; max-height: 80%;">
            </div>
          </div>
          <div class="form-group">
            <label id="linkLabel">Link do produto:</label>
            <input type="text" id="sourceLink" class="form-control"
                   placeholder="https://seusite.com/produto...">
          </div>
          <button id="btnSearch" class="btn btn-primary btn-block">Buscar</button>
        </div>

        <!-- STEP 2 -->
        <div id="step2" class="d-none">
          <h5 class="text-center mb-4">Para qual produto carregar as avaliações?</h5>
          <div class="form-group">
            <label>Selecione a loja:</label>
            <select id="shopSelect" class="form-control mb-3">
              <option value="">Selecione...</option>
              <option>droplinkfy3.myshopify.com</option>
            </select>
          </div>
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#tab-categories">
                    Categorias <span class="badge badge-primary">3</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#tab-collections">
                    Coleções <span class="badge badge-secondary">1</span>
                  </a>
                </li>
              </ul>
              <div class="tab-content mt-3">
                <div id="tab-categories" class="tab-pane fade show active">
                  <div class="form-group">
                    <label>Selecione uma categoria:</label>
                    <select id="categorySelect" class="form-control">
                      <option>Escolha...</option>
                      <option>Ecommerce</option>
                    </select>
                  </div>
                </div>
                <div id="tab-collections" class="tab-pane fade">
                  <div class="form-group">
                    <label>Selecione uma coleção:</label>
                    <select id="collectionSelect" class="form-control">
                      <option>Escolha...</option>
                      <option>Nova coleção</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group mt-3">
                <label>Buscar produtos...</label>
                <input type="text" id="productSearch" class="form-control"
                       placeholder="Digite nome e aperte Enter">
              </div>
              <ul id="selectedProducts" class="list-group mt-3"></ul>
              <div class="mt-4 text-right">
                <button id="btnBack2" class="btn btn-secondary">Voltar</button>
                <button id="btnNext2" class="btn btn-primary">Avançar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- STEP 3 -->
        <div id="step3" class="d-none">
          <h5 class="text-center mb-4">Configurações das avaliações</h5>
          <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
            <label class="btn btn-outline-secondary active">
              <input type="radio" name="reviewType" value="text" checked> Somente texto
            </label>
            <label class="btn btn-outline-secondary">
              <input type="radio" name="reviewType" value="images"> Somente com imagens
            </label>
            <label class="btn btn-outline-secondary">
              <input type="radio" name="reviewType" value="oneImage"> Uma imagem por review
            </label>
          </div>
          <div class="form-group">
            <label>Quantidade de avaliações: <span id="countLabel">75 comentários</span></label>
            <input id="countRange" type="range" class="custom-range" style="width:100%" min="1" max="200" value="75">
          </div>
          <div class="form-group">
            <label>Distribuição de gênero</label>
            <input id="genderRange" type="range" style="width:100%" class="custom-range" min="0" max="100" value="50">
            <div class="d-flex justify-content-between">
              <small><span id="malePct">50%</span> Homens</small>
              <small><span id="femalePct">50%</span> Mulheres</small>
            </div>
          </div>
          <div class="form-group">
            <label>Rating mínimo</label>
            <div class="d-flex align-items-center mb-2">
              <div id="starContainer" class="star-rating mr-3"></div>
              <span id="ratingLabel" class="badge badge-secondary p-2">4,6</span>
            </div>
            <input id="ratingRange" type="range" class="custom-range" min="0" max="5" step="0.1" value="4.6">
          </div>
          <div class="mt-4 text-right">
            <button id="btnBack3" class="btn btn-secondary">Voltar</button>
            <button id="btnNext3" class="btn btn-primary">Avançar</button>
          </div>
        </div>

        <!-- STEP 4 -->
        <div id="step4" class="d-none">
          <h5 class="text-center mb-4">Avaliações</h5>
          <div class="form-group form-inline mb-3">
            <label>
              <input type="checkbox" id="toggleAll" checked>
              <span class="ml-2">Selecionar todos</span>
            </label>
          </div>
          <div class="alert alert-info">
            <i data-feather="info"></i>
            Alterações podem levar até 2 minutos para refletir na loja.
          </div>
          <div class="row">
            @for($i=1; $i<=4; $i++)
            <div class="col-md-3 mb-4">
              <div class="card h-100 review-card selected">
                <div id="carouselRev{{ $i }}" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    @for($j=0; $j<3; $j++)
                    <div class="carousel-item {{ $j==0?'active':'' }}">
                      <img src="{{asset('assets/images/pages/img-car.png')}}" class="d-block w-100">
                    </div>
                    @endfor
                  </div>
                  <a class="carousel-control-prev" href="#carouselRev{{ $i }}" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                  </a>
                  <a class="carousel-control-next" href="#carouselRev{{ $i }}" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                  </a>
                </div>
                <div class="card-body">
                  <h6>Nome Sobrenome</h6>
                  <p><small class="text-muted">01/01/2024</small></p>
                  <p class="text-truncate" style="max-height:3rem;">Lorem ipsum dolor sit amet…</p>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                  <div>
                    <span class="badge badge-light">4.6</span>
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star-half-alt text-warning"></i>
                  </div>
                  <span class="badge badge-success sel-badge">Selecionado</span>
                </div>
              </div>
            </div>
            @endfor
          </div>
          <div class="mt-4 text-right">
            <button id="btnBack4" class="btn btn-secondary">Voltar</button>
            <button id="btnNext4" class="btn btn-primary">Avançar</button>
          </div>
        </div>

        <!-- STEP 5 -->
        <div id="step5" class="d-none text-center">
            <h5 class="mb-4">Concluído!</h5>
            <p>Sua importação foi finalizada com sucesso.</p>
            <button class="btn btn-primary mt-3" id="finishBtn">Fechar</button>
        </div>
      </div>
    </div>

    <!-- Avaliações criadas -->
    <div class="tab-pane fade" id="created">
      <p class="text-center text-muted my-5">Nenhuma avaliação importada ainda.</p>
    </div>
  </div>
</div>

<!-- Final Notification Modal -->
<div class="modal fade" id="finalModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-0">
      <div class="modal-header p-0 border-0">
        <button type="button" class="close-custom" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body text-center">
        <div class="stars-final mb-3">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <div class="store-icon-final mb-3">
          <i class="fas fa-store"></i>
        </div>
        <h5 class="message-title">Enviando reviews em segundo plano!</h5>
        <p class="message-subtitle">Você já pode fechar o aplicativo</p>
        <p class="small text-muted">
          Suas reviews estarão na sua página em alguns segundos,<br>
          estamos enviando aqui do nosso lado.
        </p>
      </div>
    </div>
  </div>
</div>

@endsection

@push('script-page')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

    document.getElementById('btnNext4').addEventListener('click', ()=>{
  Swal.fire({ icon:'success', title:'Ok!', text:'Avaliações selecionadas.', confirmButtonColor:'#007bff' })
    .then(()=>{
      goTo(5);            // mostra STEP 5
      $('#finalModal').modal('show'); // exibe o modal escuro
    });
});
document.addEventListener('DOMContentLoaded', function(){
  feather.replace();
  $('.nav-tabs a').on('click', e => { e.preventDefault(); $(e.currentTarget).tab('show'); });

  const goTo = n => {
    for(let i=1;i<=5;i++){
      document.getElementById('step'+i).classList.toggle('d-none', i!==n);
      document.querySelector(`.progress-steps .circle[data-step="${i}"]`)
              .classList.toggle('active', i===n);
    }
  };

  // STEP 1
  let selectedSource = '';
  document.querySelectorAll('.source-card').forEach(c=>{
    c.addEventListener('click', ()=>{
      document.querySelectorAll('.source-card')
              .forEach(x=>x.classList.remove('selected'));
      c.classList.add('selected');
      selectedSource = c.dataset.source;
      document.getElementById('linkLabel').textContent =
        `Link do produto ${selectedSource}:`;
    });
  });
  document.getElementById('btnSearch').addEventListener('click', ()=>{
    if(!selectedSource){
      return Swal.fire({ icon:'warning', title:'Oops...', text:'Selecione uma fonte!', confirmButtonColor:'#007bff' });
    }
    const url = document.getElementById('sourceLink').value.trim();
    if(!url){
      return Swal.fire({ icon:'error', title:'Campo vazio', text:'Digite o link.', confirmButtonColor:'#007bff' });
    }
    Swal.fire({ title:'Buscando...', didOpen:()=>Swal.showLoading(), allowOutsideClick:false });
    setTimeout(()=>{
      Swal.close(); goTo(2);
    },1000);
  });

  // STEP 2
  document.getElementById('btnBack2').addEventListener('click', ()=> goTo(1));
  document.getElementById('btnNext2').addEventListener('click', ()=> goTo(3));
  document.getElementById('productSearch').addEventListener('keyup', e=>{
    if(e.key==='Enter' && e.target.value.trim()){
      const li = document.createElement('li');
      li.className='list-group-item d-flex justify-content-between';
      li.innerHTML= `${e.target.value.trim()}<button class="btn btn-sm btn-link text-danger">&times;</button>`;
      document.getElementById('selectedProducts').appendChild(li);
      li.querySelector('button').onclick=()=>li.remove();
      e.target.value='';
    }
  });

  // STEP 3 sliders
  const countR=document.getElementById('countRange'),
        lblCount=document.getElementById('countLabel'),
        genR=document.getElementById('genderRange'),
        male=document.getElementById('malePct'),
        female=document.getElementById('femalePct'),
        rateR=document.getElementById('ratingRange'),
        lblRate=document.getElementById('ratingLabel'),
        stars=document.getElementById('starContainer');
  const renderStars=v=>{
    stars.innerHTML='';
    let full=Math.floor(v), half=v-full>=0.5;
    for(let i=0;i<full;i++) stars.innerHTML+='<i class="fa fa-star text-warning"></i>';
    if(half) stars.innerHTML+='<i class="fa fa-star-half-alt text-warning"></i>';
    for(let i=stars.querySelectorAll('i').length;i<5;i++)
      stars.innerHTML+='<i class="fa fa-star-o text-warning"></i>';
  };
  lblCount.textContent=`${countR.value} comentários`;
  countR.oninput=_=>lblCount.textContent=`${countR.value} comentários`;
  genR.oninput=_=>{
    male.textContent=`${genR.value}%`;
    female.textContent=`${100-genR.value}%`;
  };
  rateR.oninput=_=>{
    let v=parseFloat(rateR.value).toFixed(1);
    lblRate.textContent=v.replace('.',',');
    renderStars(parseFloat(v));
  };
  renderStars(parseFloat(rateR.value));
  document.getElementById('btnBack3').addEventListener('click', ()=> goTo(2));
  document.getElementById('btnNext3').addEventListener('click', ()=> goTo(4));

  // STEP 4 selection
  const toggleAll=document.getElementById('toggleAll'),
        revCards=document.querySelectorAll('.review-card');
  toggleAll.onchange=_=>{
    revCards.forEach(c=>{
      c.classList.toggle('selected', toggleAll.checked);
      c.querySelector('.sel-badge').textContent = toggleAll.checked?'Selecionado':'Selecione';
    });
  };
  revCards.forEach(c=>{
    c.onclick=_=>{
      c.classList.toggle('selected');
      c.querySelector('.sel-badge').textContent =
        c.classList.contains('selected')?'Selecionado':'Selecione';
    };
  });
  document.getElementById('btnBack4').addEventListener('click', ()=> goTo(3));
  document.getElementById('btnNext4').addEventListener('click', ()=>{
    Swal.fire({ icon:'success', title:'Ok!', text:'Avaliações selecionadas.', confirmButtonColor:'#007bff' })
      .then(()=>goTo(5));
  });
});
</script>
@endpush
