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
    /* wizard progress */
    .progress-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 2rem;
        gap: .5rem;
    }
    .progress-steps .circle {
        width: 1.5rem;
        height: 1.5rem;
        border-radius: 50%;
        border: 2px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .875rem;
        color: #666;
        background: #fff;
    }
    .progress-steps .circle.active {
        border-color: #fb6c2b;
        background: #fb6c2b;
        color: #fff;
    }
    .progress-steps .line {
        flex: 1;
        height: 2px;
        background: #ccc;
    }
    /* source cards */
    .source-card {
        width: 100px;
        height: 100px;
        border: 2px solid #ddd;
        border-radius: .5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color .2s;
    }
    .source-card.selected {
        border-color: #fb6c2b;
        background: #fb6c2b;
    }
    /* estrelas */
    .star-rating i {
        font-size: 1.5rem;
        margin-right: 2px;
    }

        .custom-range {
      -webkit-appearance: none;  /* remove estilo padrão no WebKit */
      width: 100%;
      height: 8px;
      border-radius: 5px;
      background: #fb6c2b;          /* cor do trilho “não preenchido” */
      outline: none;
      margin: 1.5rem 0;
    }

    /* 2. Trilho preenchido no Chrome/Safari */
    .custom-range::-webkit-slider-runnable-track {
      width: 100%;
      height: 8px;
      cursor: pointer;
      background: #ddd;
      border-radius: 5px;
    }

    /* 3. Trilho preenchido no Firefox */
    .custom-range::-moz-range-track {
      width: 100%;
      height: 8px;
      cursor: pointer;
      background: #ddd;
      border-radius: 5px;
    }

    /* 4. Trilho (invisível) no IE/Edge */
    .custom-range::-ms-track {
      width: 100%;
      height: 8px;
      cursor: pointer;
      background: transparent;
      border-color: transparent;
      color: transparent;
    }
    /* Em seguida definimos as cores “abaixo” e “acima” do thumb no IE/Edge */
    .custom-range::-ms-fill-lower {
      background: #fb6c2b;   /* cor do lado esquerdo (preenchido) */
      border-radius: 5px;
    }
    .custom-range::-ms-fill-upper {
      background: #ddd;      /* cor do lado direito (não preenchido) */
      border-radius: 5px;
    }

    /* 5. Thumb (ponto deslizante) no Chrome/Safari */
    .custom-range::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #fb6c2b;    /* cor do thumb */
      border: 2px solid #fb6c2b;
      margin-top: -6px;        /* centraliza verticalmente */
      cursor: pointer;
    }

    /* 6. Thumb no Firefox */
    .custom-range::-moz-range-thumb {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #fb6c2b;
      border: 2px solid #fb6c2b;
      cursor: pointer;
    }

    /* 7. Thumb no IE/Edge */
    .custom-range::-ms-thumb {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      background: #fb6c2b;
      border: 2px solid #fb6c2b;
      cursor: pointer;
    }

    /* 8. Foco (se quiser realçar quando o slider estiver em foco) */
    .custom-range:focus::-webkit-slider-runnable-track {
      background: #fb6c2b;
    }
    .custom-range:focus::-moz-range-track {
      background: #fb6c2b;
    }
</style>

<div class="container-fluid mt-4">
    <!-- abas -->
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
            <!-- wizard -->
            <div class="progress-steps">
                <div class="circle active">1</div>
                <div class="line"></div>
                <div class="circle">2</div>
                <div class="line"></div>
                <div class="circle">3</div>
                <div class="line"></div>
                <div class="circle">4</div>
                <div class="line"></div>
                <div class="circle">5</div>
            </div>

            {{-- STEP 1 --}}
            <div id="step1">
                <div class="d-flex justify-content-center mb-4">
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

                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label id="linkLabel">Link do produto</label>
                            <input type="text" id="sourceLink" class="form-control" placeholder="https://seusite.com/produto...">
                        </div>
                        <button class="btn btn-primary btn-block" id="btnSearch">Buscar</button>
                    </div>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div id="step2" class="d-none">
                <h4 class="text-center mb-4">Para qual produto carregar as avaliações?</h4>
                <div class="form-row justify-content-center">
                    <div class="form-group col-md-6">
                        <label>Selecione a loja que está o produto</label>
                        <select id="shopSelect" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="droplinkfy3.myshopify.com">droplinkfy3.myshopify.com</option>
                        </select>
                    </div>
                </div>

                <div class="card mx-auto" style="max-width: 650px;">
                    <div class="card-body">
                        {{-- abas categorias/coleções --}}
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
                                    <label>Selecione uma categoria</label>
                                    <select id="categorySelect" class="form-control">
                                        <option value="">Escolha...</option>
                                        <option value="ecommerce">Ecommerce</option>
                                    </select>
                                </div>
                            </div>
                            <div id="tab-collections" class="tab-pane fade">
                                <div class="form-group">
                                    <label>Selecione uma coleção</label>
                                    <select id="collectionSelect" class="form-control">
                                        <option value="">Escolha...</option>
                                        <option value="nova-colecao">Nova coleção</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Buscar produtos...</label>
                            <input type="text" id="productSearch" class="form-control" placeholder="Digite o nome e pressione Enter">
                        </div>

                        <ul id="selectedProducts" class="list-group mt-3"></ul>

                        <div class="mt-4 text-right">
                            <button id="btnBack2" class="btn btn-secondary">Voltar</button>
                            <button id="btnNext2" class="btn btn-primary">Avançar</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div id="step3" class="d-none">
                <h4 class="text-center mb-4">Quais as configurações das avaliações?</h4>

              <div class="card">
                <div class="card-body">
                      {{-- tipo de review --}}
                <div class="btn-group btn-group-toggle mb-4" data-toggle="buttons">
                    <label class="btn btn btn-outline-secondary active">
                        <input type="radio" name="reviewType" value="text" autocomplete="off" checked> Somente texto
                    </label>
                    <label class="btn btn btn-outline-secondary">
                        <input type="radio" name="reviewType" value="images" autocomplete="off"> Somente com imagens
                    </label>
                    <label class="btn btn btn-outline-secondary">
                        <input type="radio" name="reviewType" value="oneImage" autocomplete="off"> Uma imagem por review
                    </label>
                </div>

                {{-- quantidade de avaliações --}}
                <div class="form-group">
                    <label>Quantidade de avaliações: <span id="countLabel">75 comentários</span></label>
                    <input type="range" class="custom-range"style="width: 100%;" id="countRange" min="1" max="200" value="75">
                </div>

                {{-- distribuição de gênero --}}
                <div class="form-group">
                    <label>Distribuição de gênero das avaliações</label>
                    <input type="range" class="custom-range" id="genderRange" style="width: 100%;" min="0" max="100" value="50">
                    <div class="d-flex justify-content-between">
                        <small><span id="malePct">50%</span> Homens</small>
                        <small><span id="femalePct">50%</span> Mulheres</small>
                    </div>
                </div>

                {{-- rating mínimo --}}
                <div class="form-group">
                    <label>Quantas estrelas, no mínimo, precisa ter as avaliações?</label>
                    <div class="d-flex align-items-center">
                        <div class="star-rating mr-2" id="starContainer">
                            <!-- estrelas serão geradas via JS -->
                        </div>
                        <div class="badge badge-secondary p-2" id="ratingLabel">4,6</div>
                    </div>
                    <input type="range" class="custom-range mt-2" id="ratingRange" min="0" max="5" step="0.1" value="4.6">
                </div>
                </div>
              </div>

                <div class="mt-4 text-right">
                    <button id="btnBack3" class="btn btn-secondary">Voltar</button>
                    <button id="btnNext3" class="btn btn-primary">Avançar</button>
                </div>
            </div>
        </div>

        <!-- Avaliações criadas -->
        <div class="tab-pane fade" id="created">
            <p class="text-center text-muted my-5">Nenhuma avaliação importada ainda.</p>
        </div>
    </div>
</div>
@endsection

@push('script-page')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    $('.nav-tabs a').on('click', e => {
        e.preventDefault();
        $(e.currentTarget).tab('show');
    });

    // Step 1
    const cards        = document.querySelectorAll('.source-card');
    const linkLabel    = document.getElementById('linkLabel');
    let selectedSource = '';
    cards.forEach(c => c.addEventListener('click', () => {
        cards.forEach(x => x.classList.remove('selected'));
        c.classList.add('selected');
        selectedSource = c.dataset.source;
        linkLabel.textContent = `Link do produto ${selectedSource}:`;
    }));

    document.getElementById('btnSearch').addEventListener('click', () => {
        if (!selectedSource) {
            return Swal.fire({ icon:'warning', title:'Oops...', text:'Selecione uma fonte!', confirmButtonColor:'#007bff' });
        }
        const url = document.getElementById('sourceLink').value.trim();
        if (!url) {
            return Swal.fire({ icon:'error', title:'Campo vazio', text:'Digite o link para continuar.', confirmButtonColor:'#007bff' });
        }
        Swal.fire({ title:'Buscando avaliações...', didOpen:()=>Swal.showLoading(), allowOutsideClick:false });
        setTimeout(() => {
            Swal.fire({ icon:'success', title:'Pronto!', text:`Avaliações de ${selectedSource} importadas.`, confirmButtonColor:'#007bff' })
                .then(r => {
                    if (r.isConfirmed) {
                        // show step2
                        document.getElementById('step1').classList.add('d-none');
                        document.getElementById('step2').classList.remove('d-none');
                        document.querySelectorAll('.progress-steps .circle')[1].classList.add('active');
                    }
                });
        }, 1200);
    });

    // Step 2
    document.getElementById('btnBack2').addEventListener('click', () => {
        document.getElementById('step2').classList.add('d-none');
        document.getElementById('step1').classList.remove('d-none');
        const circles = document.querySelectorAll('.progress-steps .circle');
        circles[1].classList.remove('active');
    });

    document.getElementById('productSearch').addEventListener('keyup', e => {
        if (e.key==='Enter' && e.target.value.trim()) {
            const name = e.target.value.trim();
            const li   = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `${name}
                <button class="btn btn-link text-danger btn-sm remove-product">
                    <i class="fa fa-trash"></i>
                </button>`;
            document.getElementById('selectedProducts').appendChild(li);
            li.querySelector('.remove-product').addEventListener('click', ()=>li.remove());
            e.target.value = '';
        }
    });

    document.getElementById('btnNext2').addEventListener('click', () => {
        document.getElementById('step2').classList.add('d-none');
        document.getElementById('step3').classList.remove('d-none');
        document.querySelectorAll('.progress-steps .circle')[2].classList.add('active');
    });

    // Step 3
    document.getElementById('btnBack3').addEventListener('click', () => {
        document.getElementById('step3').classList.add('d-none');
        document.getElementById('step2').classList.remove('d-none');
        document.querySelectorAll('.progress-steps .circle')[2].classList.remove('active');
    });

    // sliders Step 3
    const countRange  = document.getElementById('countRange');
    const countLabel  = document.getElementById('countLabel');
    const genderRange = document.getElementById('genderRange');
    const malePct     = document.getElementById('malePct');
    const femalePct   = document.getElementById('femalePct');
    const ratingRange = document.getElementById('ratingRange');
    const ratingLabel = document.getElementById('ratingLabel');
    const starCont    = document.getElementById('starContainer');

    function renderStars(value) {
        starCont.innerHTML = '';
        const full = Math.floor(value);
        const half = (value - full) >= 0.5;
        for (let i=0; i<full; i++) starCont.innerHTML += '<i class="fa fa-star text-warning"></i>';
        if (half) starCont.innerHTML += '<i class="fa fa-star-half-o text-warning"></i>';
        for (let i=starCont.querySelectorAll('i').length; i<5; i++) {
            starCont.innerHTML += '<i class="fa fa-star-o text-warning"></i>';
        }
    }

    // inicia com valores padrão
    countLabel.textContent = `${countRange.value} comentários`;
    genderRange.dispatchEvent(new Event('input'));
    ratingLabel.textContent = ratingRange.value.replace('.',',');
    renderStars(parseFloat(ratingRange.value));

    countRange.addEventListener('input', () => {
        countLabel.textContent = `${countRange.value} comentários`;
    });
    genderRange.addEventListener('input', () => {
        malePct.textContent   = `${genderRange.value}%`;
        femalePct.textContent = `${100 - genderRange.value}%`;
    });
    ratingRange.addEventListener('input', () => {
        const v = parseFloat(ratingRange.value).toFixed(1);
        ratingLabel.textContent = v.replace('.',',');
        renderStars(parseFloat(v));
    });

    // Próximo (STEP 4) — adapte para a próxima etapa
    document.getElementById('btnNext3').addEventListener('click', () => {
        Swal.fire({ icon:'info', title:'STEP 4', text:'Implemente o próximo passo aqui.', confirmButtonColor:'#007bff' });
    });
});
</script>
@endpush
