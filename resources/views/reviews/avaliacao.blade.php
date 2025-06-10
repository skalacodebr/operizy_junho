@extends('layouts.admin')

@section('page-title')
    Review
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Review</a></li>
    <li class="breadcrumb-item active" aria-current="page">Avaliações</li>
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block text-white font-weight-bold mb-0">Avaliações</h5>
    </div>
@endsection

@section('content')
<style>
    /* utilitário de gap */
    .flex-gap { display: flex; gap: 1rem; }
    .img-produto { width: 100px; }
    .img-produto-small { width: 40px; }
    .wizard-container { position: relative; padding: 2rem; }
    .wizard-step { display: none; }
    .wizard-step.active { display: block; }
    .wizard-arrow {
      position: absolute; top: 50%; transform: translateY(-50%);
      background: none; border: none; font-size: 1.5rem; color: #333;
    }
    .wizard-arrow.prev { left: -1rem; }
    .wizard-arrow.next { right: -1rem; }
    .wizard-progress {
      display: flex; justify-content: space-between; align-items: center;
      margin-top: 1.5rem;
    }
    .wizard-progress .step {
      flex: 1; text-align: center; position: relative;
    }
    .wizard-progress .step:not(:last-child)::after {
      content: ''; position: absolute; top: 50%; right: 0;
      width: 100%; height: 2px; background: #ddd; transform: translateY(-50%);
      z-index: -1;
    }
    .wizard-progress .step-number {
      display: inline-block; width: 1.5rem; height: 1.5rem;
      line-height: 1.5rem; border-radius: 50%; background: #ddd; color: #555;
    }
    .wizard-progress .active .step-number {
      background: #333; color: #fff;
    }
    #wizardStatus { font-weight: bold; }

    .wizard-arrow svg {
        color:#fff
    }

    .list-group {
        border: 1px solid #3e3f4a
    }

    .btn-curtir {
        height: 40px;
    } 

.btn-purple {
    background: #d8652b;
    color: #fff;
}
.btn-purple:hover {
    background:rgb(236, 87, 12);
    color: #fff;
}
</style>

<div class="container-fluid mt-4">
    <!-- cabeçalho: filtros, ordenação e busca -->
    <div class="d-flex flex-gap justify-content-between align-items-center mb-3">
        <div class="btn-group mb-2">
            <button class="btn btn-outline-secondary">
                <i data-feather="filter"></i> Filtros
            </button>
            <button class="btn btn-outline-secondary">
                <i data-feather="arrow-down"></i> Mais novo
            </button>
        </div>
        <div class="input-group mb-2" style="max-width: 300px;">
            <input type="text" class="form-control" placeholder="Buscar produtos...">
            <div class="input-group-append">
                <span class="input-group-text"><i data-feather="search"></i></span>
            </div>
        </div>
    </div>

    <!-- abas -->
    <ul class="nav nav-tabs mb-4" id="avaliacoesTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="todos-tab" data-toggle="tab" href="#todos" role="tab">
                Todos <span class="badge badge-secondary ml-1">4</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="avaliados-tab" data-toggle="tab" href="#avaliados" role="tab">
                Avaliações <span class="badge badge-secondary ml-1">1</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="nao-avaliados-tab" data-toggle="tab" href="#nao-avaliados" role="tab">
                Não avaliados <span class="badge badge-secondary ml-1">1</span>
            </a>
        </li>
    </ul>

    <div class="tab-content" id="avaliacoesTabsContent">
        {{-- Aba “Todos” --}}
        <div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="todos-tab">
            <div class="list-group list-group-flush">
                <!-- exemplo: item com avaliação expandido -->
                <div class="list-group-item py-4">
                    <div class="d-flex flex-gap justify-content-between mb-3">
                        <div class="d-flex flex-gap">
                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                 alt="Blusa de Botão"
                                 class="rounded img-produto">
                            <div>
                                <strong>Blusa de Botão</strong><br>
                                <small class="text-muted">SKU: 19038403 | 19/11/2024</small><br>
                                <i class="fas fa-star text-warning"></i>
                                <strong>5.0</strong>
                                <small>(6 avaliações)</small><br>
                                <small class="text-muted">2 dias atrás</small><br>
                                <strong>Marcelo Carvalho</strong>
                            </div>
                        </div>
                        <div class="text-right flex-gap align-items-center">
                            <a href="#" class="text-secondary"><i data-feather="eye"></i></a>
                            <button class="btn btn-sm btn-outline-secondary btn-curtir"><i data-feather="heart"></i></button>
                            <button class="btn btn-sm btn-outline-danger btn-curtir"><i data-feather="trash-2"></i></button>
                            <span class="badge badge-success align-self-center">Aprovado</span>
                        </div>
                    </div>

                    <p class="mb-2"><strong>Qualidade:</strong> Perfeito!</p>
                    <p class="mb-2"><strong>Parecido com o anúncio:</strong> Sem dúvidas!</p>
                    <p class="mb-0">Produto de ótima qualidade e com a entrega super rápida!</p>

                    <div class="flex-gap my-3">
                        @for ($i = 0; $i < 3; $i++)
                        <div class="position-relative">
                            <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                                 class="rounded img-produto-small" alt="Media">
                            <div class="position-absolute"
                                 style="bottom:5px; right:5px;
                                        background:rgba(0,0,0,0.6);
                                        color:#fff; font-size:12px;
                                        padding:2px 4px;">
                                0:15
                            </div>
                        </div>
                        @endfor
                    </div>
                    <button class="btn btn-link p-0">Ver menos</button>
                </div>

                <!-- exemplo: item sem avaliação -->
                <div class="list-group-item py-3 d-flex flex-gap justify-content-between align-items-center">
                    <div class="d-flex flex-gap align-items-center">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             alt="Blusa de Botão"
                             class="rounded img-produto-small">
                        <div>
                            <strong>Blusa de Botão</strong><br>
                            <small class="text-muted">SKU: 19038403 | 19/11/2024</small>
                        </div>
                    </div>
                    <button class="btn btn-purple incentiv-btn"id="openWizard">
                        <i class="fas fa-star mr-1"></i> Incentivar avaliação
                    </button>
                </div>
            </div>
        </div>

        {{-- Aba “Avaliações” --}}
        <div class="tab-pane fade" id="avaliados" role="tabpanel" aria-labelledby="avaliados-tab">
            <div class="list-group list-group-flush">
                {{-- ... --}}
            </div>
        </div>

        {{-- Aba “Não avaliados” --}}
        <div class="tab-pane fade" id="nao-avaliados" role="tabpanel" aria-labelledby="nao-avaliados-tab">
            <div class="list-group list-group-flush">
                {{-- ... --}}
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="wizardModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="wizard-container">

          <!-- seta previous -->
          <button type="button" class="wizard-arrow prev" id="wizardPrev">
            <i data-feather="chevron-left"></i>
          </button>

          <!-- STEP 1: Rating -->
          <div class="wizard-step" data-step="1">
            <h5 class="text-center mb-4">Como você avalia este item?</h5>
            <div class="list-group">
              @php
                $ratings = [
                  5 => 'Ótimo',
                  4 => 'Muito bom',
                  3 => 'Bom',
                  2 => 'Razoável',
                  1 => 'Ruim'
                ];
              @endphp
              @foreach($ratings as $score => $label)
              <button type="button"
                      class="list-group-item list-group-item-action flex-gap rating-option"
                      data-rating="{{ $score }}">
                <div class="flex-gap align-items-center">
                  @for($i=1; $i<=5; $i++)
                    <i class="fas fa-star{{ $i <= $score ? '' : '-o' }} text-warning"></i>
                  @endfor
                  <span class="ml-2">{{ $label }}</span>
                </div>
              </button>
              @endforeach
            </div>
          </div>

          <!-- STEP 2: Comment -->
          <div class="wizard-step" data-step="2">
            <h5 class="text-center mb-4">Conte-nos mais!</h5>
            <div class="form-group">
              <textarea id="wizardComment" class="form-control" rows="4" placeholder="Compartilhe sua experiência..."></textarea>
            </div>
          </div>

          <!-- STEP 3: Upload / Record -->
          <div class="wizard-step" data-step="3">
            <h5 class="text-center mb-4">Mostre-o</h5>
            <div class="d-flex justify-content-around gap-2">
              <div class="border rounded p-4 text-center upload-box">
                <i data-feather="upload-cloud"></i>
                <p class="mt-2 text-purple">Clique para fazer o upload</p>
                <small class="text-muted">ou arraste e solte aqui</small>
                <input type="file" id="wizardUpload" class="d-none">
              </div>
              <div class="border rounded p-4 text-center record-box">
                <i data-feather="camera"></i>
                <p class="mt-2 text-purple">Gravar</p>
                <small class="text-muted">Clique aqui e comece a gravar</small>
              </div>
            </div>
          </div>

          <!-- STEP 4: Thank you / Coupon -->
          <div class="wizard-step" data-step="4">
            <h5 class="text-center mb-2">Obrigado!</h5>
            <p class="text-center text-muted mb-4">Obrigado por enviar seu feedback</p>
            <div class="text-center mb-4">
              <button class="btn btn-outline-secondary" id="copyCoupon">VALE10 <i class="fas fa-copy ml-1"></i></button>
            </div>
            <div class="text-center">
              <button class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
          </div>

          <!-- seta next -->
          <button type="button" class="wizard-arrow next" id="wizardNext">
            <i data-feather="chevron-right"></i>
          </button>

        </div>

        <!-- Progress Indicator -->
        <div class="wizard-progress">
          @for($i=1; $i<=4; $i++)
            <div class="step" data-step="{{ $i }}">
              <span class="step-number">{{ $i }}</span>
            </div>
          @endfor
        </div>
        <div class="text-center mt-2">
          <small id="wizardStatus">1/4</small>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('script-page')
<script>
document.addEventListener('DOMContentLoaded', function(){
  // Feather icons
  feather.replace();

  let current = 1, total = 4;
  const steps     = document.querySelectorAll('.wizard-step');
  const progress  = document.querySelectorAll('.wizard-progress .step');
  const status    = document.getElementById('wizardStatus');
  const prevBtn   = document.getElementById('wizardPrev');
  const nextBtn   = document.getElementById('wizardNext');

  function showStep(n) {
    steps.forEach(s => s.classList.toggle('active', +s.dataset.step === n));
    progress.forEach(p => p.classList.toggle('active', +p.dataset.step === n));
    status.textContent = n + '/' + total;
    prevBtn.style.visibility = n === 1 ? 'hidden' : 'visible';
    nextBtn.style.visibility = n === total ? 'hidden' : 'visible';
  }

  showStep(current);

  // abrir modal
  document.getElementById('openWizard')
          .addEventListener('click', () => $('#wizardModal').modal('show'));

  // navegação
  prevBtn.addEventListener('click', () => { if(current>1) showStep(--current); });
  nextBtn.addEventListener('click', () => { if(current<total) showStep(++current); });

  // rating click → avança
  document.querySelectorAll('.rating-option').forEach(btn => {
    btn.addEventListener('click', () => {
      current = 2; showStep(2);
    });
  });

  // upload-box
  document.querySelector('.upload-box').addEventListener('click', () => {
    document.getElementById('wizardUpload').click();
  });

  // record-box (placeholder)
  document.querySelector('.record-box').addEventListener('click', () => {
    alert('Implementar gravação de vídeo aqui');
  });

  // copiar cupom
  document.getElementById('copyCoupon')
          .addEventListener('click', function(){
    navigator.clipboard.writeText('VALE10');
    this.textContent = 'Copiado!';
  });
});
</script>
@endpush
