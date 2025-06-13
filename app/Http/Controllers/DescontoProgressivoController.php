<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DescontoProgressivoRequest;
use App\Http\Requests\FreteGratisRequest;

final class DescontoProgressivoController extends Controller
{
    public function index()
    {
        return view('desconto-progressivo.index');
    }



    public function cupons()
    {
        return view('desconto-progressivo.cupons');
    }

    /**
     * Mostra a loja e produtos do usuário autenticado
     * 
     * @return \Illuminate\Http\Response
     */
    public function minhaLojaEProdutos()
    {
        try {
            // Pegar o ID do usuário autenticado
            $usuarioId = \Auth::id();
            
            if (!$usuarioId) {
                return response()->json([
                    'erro' => 'Usuário não autenticado'
                ], 401);
            }

            // Buscar informações do usuário e sua loja atual usando DB::table
            $usuario = \DB::table('users')
                ->select('id', 'name', 'email', 'current_store')
                ->where('id', $usuarioId)
                ->first();

            if (!$usuario || !$usuario->current_store) {
                return response()->json([
                    'erro' => 'Usuário não possui loja associada'
                ], 404);
            }

            // Buscar informações da loja
            $loja = \DB::table('stores')
                ->select('id', 'name', 'email', 'slug', 'currency', 'currency_code', 'address', 'city', 'state', 'zipcode', 'country', 'created_at')
                ->where('id', $usuario->current_store)
                ->first();

            if (!$loja) {
                return response()->json([
                    'erro' => 'Loja não encontrada'
                ], 404);
            }

            // Buscar produtos da loja
            $produtos = \DB::table('products')
                ->select('id', 'name', 'SKU', 'price', 'last_price', 'quantity', 'min_stock', 'max_stock', 'product_display', 'is_active', 'description', 'created_at', 'updated_at')
                ->where('store_id', $loja->id)
                ->where('is_active', 1)
                ->orderBy('created_at', 'desc')
                ->get();

            // Buscar imagens dos produtos (se existirem)
            $produtosComImagens = [];
            foreach ($produtos as $produto) {
                $imagens = \DB::table('product_images')
                    ->select('product_images')
                    ->where('product_id', $produto->id)
                    ->get();

                $produtosComImagens[] = [
                    'produto' => $produto,
                    'imagens' => $imagens
                ];
            }

            // Montar resposta
            $dadosCompletos = [
                'usuario' => [
                    'id' => $usuario->id,
                    'nome' => $usuario->name,
                    'email' => $usuario->email
                ],
                'loja' => [
                    'id' => $loja->id,
                    'nome' => $loja->name,
                    'email' => $loja->email,
                    'slug' => $loja->slug,
                    'moeda' => $loja->currency,
                    'codigo_moeda' => $loja->currency_code,
                    'endereco_completo' => trim(implode(', ', array_filter([
                        $loja->address,
                        $loja->city,
                        $loja->state,
                        $loja->zipcode,
                        $loja->country
                    ]))),
                    'criada_em' => $loja->created_at
                ],
                'produtos' => $produtosComImagens,
                'estatisticas' => [
                    'total_produtos' => count($produtos),
                    'produtos_ativos' => count(array_filter($produtos->toArray(), function($p) { 
                        return $p->is_active == 1; 
                    })),
                    'produtos_com_estoque' => count(array_filter($produtos->toArray(), function($p) { 
                        return $p->quantity > 0; 
                    }))
                ]
            ];

            return response()->json([
                'sucesso' => true,
                'dados' => $dadosCompletos
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Erro ao buscar loja e produtos do usuário: ' . $e->getMessage());
            
            return response()->json([
                'erro' => 'Erro interno do servidor',
                'detalhes' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Mostra os clientes da loja do usuário autenticado
     * 
     * @return \Illuminate\Http\Response
     */
    public function minhosClientes()
    {
        try {
            // Pegar o ID do usuário autenticado
            $usuarioId = \Auth::id();
            
            if (!$usuarioId) {
                return response()->json([
                    'erro' => 'Usuário não autenticado'
                ], 401);
            }

            // Buscar informações do usuário e sua loja atual usando DB::table
            $usuario = \DB::table('users')
                ->select('id', 'name', 'email', 'current_store')
                ->where('id', $usuarioId)
                ->first();

            if (!$usuario || !$usuario->current_store) {
                return response()->json([
                    'erro' => 'Usuário não possui loja associada'
                ], 404);
            }

            // Buscar informações da loja
            $loja = \DB::table('stores')
                ->select('id', 'name', 'email', 'slug')
                ->where('id', $usuario->current_store)
                ->first();

            if (!$loja) {
                return response()->json([
                    'erro' => 'Loja não encontrada'
                ], 404);
            }

            // Buscar clientes da loja
            $clientes = \DB::table('customers')
                ->select('id', 'name', 'email', 'phone_number', 'avatar', 'lang', 'created_at', 'updated_at')
                ->where('store_id', $loja->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Montar resposta
            $dadosCompletos = [
                'usuario' => [
                    'id' => $usuario->id,
                    'nome' => $usuario->name,
                    'email' => $usuario->email
                ],
                'loja' => [
                    'id' => $loja->id,
                    'nome' => $loja->name,
                    'email' => $loja->email,
                    'slug' => $loja->slug
                ],
                'clientes' => $clientes,
                'estatisticas' => [
                    'total_clientes' => count($clientes),
                    'clientes_com_telefone' => count(array_filter($clientes->toArray(), function($c) { 
                        return !empty($c->phone_number); 
                    })),
                    'clientes_com_avatar' => count(array_filter($clientes->toArray(), function($c) { 
                        return !empty($c->avatar) && $c->avatar !== 'avatar.png'; 
                    }))
                ]
            ];

            return response()->json([
                'sucesso' => true,
                'dados' => $dadosCompletos
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Erro ao buscar clientes da loja do usuário: ' . $e->getMessage());
            
            return response()->json([
                'erro' => 'Erro interno do servidor',
                'detalhes' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Salva um novo desconto progressivo
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function salvarDesconto(DescontoProgressivoRequest $request)
    {
        try {
            // Validar se o usuário está autenticado
            $usuarioId = \Auth::id();
            
            if (!$usuarioId) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não autenticado'
                ], 401);
            }

            // Buscar informações do usuário e sua loja atual
            $usuario = \DB::table('users')
                ->select('id', 'name', 'email', 'current_store')
                ->where('id', $usuarioId)
                ->first();

            if (!$usuario || !$usuario->current_store) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não possui loja associada'
                ], 404);
            }

            // Dados já foram validados pelo Form Request
            $dadosValidados = $request->validated();

            // Validações customizadas já são feitas no Form Request

            // Iniciar transação
            \DB::beginTransaction();

            // 1. Inserir desconto progressivo principal
            $descontoProgressivoId = \DB::table('descontos_progressivos')->insertGetId([
                'titulo' => $dadosValidados['titulo'],
                'ativo' => $dadosValidados['ativo'],
                'valor_minimo_produto' => $dadosValidados['valorMinimo'] ?? 0.00,
                'limitar_data' => $dadosValidados['limitarData'],
                'data_inicio' => $dadosValidados['limitarData'] ? $dadosValidados['dataInicio'] : null,
                'data_fim' => $dadosValidados['limitarData'] ? $dadosValidados['dataFim'] : null,
                'todos_produtos' => $dadosValidados['todosProdutos'],
                'tipo_aplicacao' => $dadosValidados['tipoAplicacao'],
                'tipo_clientes' => $dadosValidados['tipoClientes'],
                'permitir_outras_promocoes' => $dadosValidados['permitirOutrasPromocoes'],
                'store_id' => $usuario->current_store,
                'created_by' => $usuarioId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 2. Inserir regras de desconto
            foreach ($dadosValidados['regrasDesconto'] as $index => $regra) {
                \DB::table('desconto_progressivo_regras')->insert([
                    'desconto_progressivo_id' => $descontoProgressivoId,
                    'porcentagem_desconto' => $regra['desconto'],
                    'quantidade_minima' => $regra['quantidade'],
                    'ordem' => $index + 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // 3. Inserir estados específicos (se houver)
            if (isset($dadosValidados['estadosSelecionados']) && !empty($dadosValidados['estadosSelecionados'])) {
                $estadosBrasil = [
                    'Acre' => 'AC', 'Alagoas' => 'AL', 'Amapá' => 'AP', 'Amazonas' => 'AM',
                    'Bahia' => 'BA', 'Ceará' => 'CE', 'Distrito Federal' => 'DF', 'Espírito Santo' => 'ES',
                    'Goiás' => 'GO', 'Maranhão' => 'MA', 'Mato Grosso' => 'MT', 'Mato Grosso do Sul' => 'MS',
                    'Minas Gerais' => 'MG', 'Pará' => 'PA', 'Paraíba' => 'PB', 'Paraná' => 'PR',
                    'Pernambuco' => 'PE', 'Piauí' => 'PI', 'Rio de Janeiro' => 'RJ', 'Rio Grande do Norte' => 'RN',
                    'Rio Grande do Sul' => 'RS', 'Rondônia' => 'RO', 'Roraima' => 'RR', 'Santa Catarina' => 'SC',
                    'São Paulo' => 'SP', 'Sergipe' => 'SE', 'Tocantins' => 'TO'
                ];

                foreach ($dadosValidados['estadosSelecionados'] as $estado) {
                    if (isset($estadosBrasil[$estado])) {
                        \DB::table('desconto_progressivo_estados')->insert([
                            'desconto_progressivo_id' => $descontoProgressivoId,
                            'estado' => $estado,
                            'sigla' => $estadosBrasil[$estado],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            // 4. Inserir clientes específicos (se houver)
            if ($dadosValidados['tipoClientes'] === 'especificos' && 
                isset($dadosValidados['clientesSelecionados']) && 
                !empty($dadosValidados['clientesSelecionados'])) {
                
                foreach ($dadosValidados['clientesSelecionados'] as $cliente) {
                    \DB::table('desconto_progressivo_clientes')->insert([
                        'desconto_progressivo_id' => $descontoProgressivoId,
                        'customer_id' => $cliente['id'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // 5. Inserir produtos específicos (se não for todos os produtos)
            if (!$dadosValidados['todosProdutos'] && 
                isset($dadosValidados['produtosSelecionados']) && 
                !empty($dadosValidados['produtosSelecionados'])) {
                
                if ($dadosValidados['tipoAplicacao'] === 'produtos') {
                    foreach ($dadosValidados['produtosSelecionados'] as $produto) {
                        \DB::table('desconto_progressivo_produtos')->insert([
                            'desconto_progressivo_id' => $descontoProgressivoId,
                            'product_id' => $produto['id'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
                // TODO: Implementar para categorias e marcas quando necessário
            }

            // Confirmar transação
            \DB::commit();

            // Log da ação
            \Log::info('Desconto progressivo criado com sucesso', [
                'desconto_id' => $descontoProgressivoId,
                'usuario_id' => $usuarioId,
                'loja_id' => $usuario->current_store,
                'titulo' => $dadosValidados['titulo']
            ]);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Desconto Progressivo salvo com sucesso!',
                'dados' => [
                    'id' => $descontoProgressivoId,
                    'titulo' => $dadosValidados['titulo'],
                    'ativo' => $dadosValidados['ativo']
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            
            return response()->json([
                'sucesso' => false,
                'erro' => 'Dados inválidos',
                'detalhes' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Erro ao salvar desconto progressivo: ' . $e->getMessage(), [
                'usuario_id' => $usuarioId ?? null,
                'dados_request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'sucesso' => false,
                'erro' => 'Erro interno do servidor. Tente novamente.',
                'detalhes' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }



    

    public function frete_gratis_index()
    {
        return view('desconto-progressivo.frete-gratis');
    }

    /**
     * Salva um novo frete grátis
     * 
     * @param \App\Http\Requests\FreteGratisRequest $request
     * @return \Illuminate\Http\Response
     */
    public function salvarFreteGratis(FreteGratisRequest $request)
    {
        try {
            // Validar se o usuário está autenticado
            $usuarioId = \Auth::id();
            
            if (!$usuarioId) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não autenticado'
                ], 401);
            }

            // Buscar informações do usuário e sua loja atual
            $usuario = \DB::table('users')
                ->select('id', 'name', 'email', 'current_store')
                ->where('id', $usuarioId)
                ->first();

            if (!$usuario || !$usuario->current_store) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não possui loja associada'
                ], 404);
            }

            // Dados já foram validados pelo Form Request
            $dadosValidados = $request->validated();

            // Iniciar transação
            \DB::beginTransaction();

            // 1. Inserir frete grátis principal
            $freteGratisId = \DB::table('frete_gratis')->insertGetId([
                'descricao' => $dadosValidados['descricaoCupom'],
                'ativo' => $dadosValidados['ativo'],
                'tipo_desconto' => $dadosValidados['tipoDesconto'],
                'valor_desconto' => $dadosValidados['tipoDesconto'] === 'porcentagem' ? 
                    $dadosValidados['porcentagemDesconto'] : $dadosValidados['valorFixoDesconto'],
                'condicao_aplicacao' => $dadosValidados['condicaoAplicacao'],
                'valor_minimo' => $dadosValidados['condicaoAplicacao'] === 'valor_minimo' ? 
                    $dadosValidados['valorMinimoProduto'] : null,
                'quantidade_minima' => $dadosValidados['condicaoAplicacao'] === 'quantidade_minima' ? 
                    $dadosValidados['quantidadeMinimaProdutos'] : null,
                'limitar_data' => $dadosValidados['limitarData'],
                'data_inicio' => $dadosValidados['limitarData'] ? $dadosValidados['dataInicio'] : null,
                'data_fim' => $dadosValidados['limitarData'] ? $dadosValidados['dataFim'] : null,
                'todos_clientes' => $dadosValidados['tipoClientes'] === 'todos',
                'todos_produtos' => $dadosValidados['todosProdutos'],
                'permitir_outras_promocoes' => $dadosValidados['permitirOutrasPromocoes'],
                'store_id' => $usuario->current_store,
                'created_by' => $usuarioId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // 3. Inserir estados específicos (se houver)
            if (isset($dadosValidados['estadosSelecionados']) && !empty($dadosValidados['estadosSelecionados'])) {
                foreach ($dadosValidados['estadosSelecionados'] as $estado) {
                    \DB::table('frete_gratis_estados')->insert([
                        'frete_gratis_id' => $freteGratisId,
                        'estado' => $estado,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // 4. Inserir clientes específicos (se houver)
            if ($dadosValidados['tipoClientes'] === 'especificos' && 
                isset($dadosValidados['clientesSelecionados']) && 
                !empty($dadosValidados['clientesSelecionados'])) {
                
                foreach ($dadosValidados['clientesSelecionados'] as $cliente) {
                    \DB::table('frete_gratis_clientes')->insert([
                        'frete_gratis_id' => $freteGratisId,
                        'cliente_id' => $cliente['id'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // 5. Inserir produtos específicos (se não for todos os produtos)
            if (!$dadosValidados['todosProdutos'] && 
                isset($dadosValidados['produtosSelecionados']) && 
                !empty($dadosValidados['produtosSelecionados'])) {
                
                foreach ($dadosValidados['produtosSelecionados'] as $produto) {
                    \DB::table('frete_gratis_produtos')->insert([
                        'frete_gratis_id' => $freteGratisId,
                        'produto_id' => $produto['id'],
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }

            // Confirmar transação
            \DB::commit();

            // Log da ação
            \Log::info('Frete grátis criado com sucesso', [
                'frete_gratis_id' => $freteGratisId,
                'usuario_id' => $usuarioId,
                'loja_id' => $usuario->current_store,
                'descricao' => $dadosValidados['descricaoCupom']
            ]);

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Frete Grátis salvo com sucesso!',
                'dados' => [
                    'id' => $freteGratisId,
                    'descricao' => $dadosValidados['descricaoCupom'],
                    'ativo' => $dadosValidados['ativo']
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \DB::rollBack();
            
            return response()->json([
                'sucesso' => false,
                'erro' => 'Dados inválidos',
                'detalhes' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Erro ao salvar frete grátis: ' . $e->getMessage(), [
                'usuario_id' => $usuarioId ?? null,
                'dados_request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'sucesso' => false,
                'erro' => 'Erro interno do servidor. Tente novamente.',
                'detalhes' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }






    public function leve_mais_ganhe_index()
    {
        return view('desconto-progressivo.leve-mais-ganhe');
    }

    public function salvarLeveMaisPagueMenos(\Illuminate\Http\Request $request)
    {
        try {
            $usuarioId = $request->user()->id ?? 1; // ou defina um valor fixo para teste
            $storeId = 1; // Defina conforme sua lógica

            \DB::beginTransaction();

            $promoId = \DB::table('leve_mais_pague_menos')->insertGetId([
                'titulo' => $request->input('tituloPromocao'),
                'descricao' => $request->input('descricaoCupom'),
                'ativo' => $request->input('ativo', true),
                'valor_minimo' => $request->input('valorMinimo') ?: null,
                'exigir_valor_minimo' => $request->input('ativarValorMinimo', false),
                'data_inicio' => $request->input('dataInicio'),
                'data_fim' => $request->input('dataFim'),
                'created_by' => $usuarioId,
                'store_id' => $storeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \DB::table('leve_mais_pague_menos_regras')->insert([
                'leve_mais_pague_menos_id' => $promoId,
                'quantidade_compra' => $request->input('quantidadeCompra'),
                'quantidade_desconto' => $request->input('quantidadeDesconto'),
                'percentual_desconto' => 100.00,
                'ordem' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \DB::commit();

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Promoção salva com sucesso!',
                'id' => $promoId
            ], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'sucesso' => false,
                'erro' => 'Erro ao salvar promoção',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }






    public function desconto_em_massa_index()
    {
        return view('desconto-progressivo.desconto-em-massa');
    }


    /**
     * Salva um novo Desconto em Massa
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function salvarDescontoEmMassa(Request $request)
    {
        try {
            // Log dos dados recebidos para depuração
            \Log::info('Dados recebidos para salvar desconto em massa:', $request->all());
            
            $usuarioId = \Auth::id();
            if (!$usuarioId) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não autenticado'
                ], 401);
            }

            // Buscar informações do usuário e sua loja atual
            $usuario = \DB::table('users')
                ->select('id', 'name', 'email', 'current_store')
                ->where('id', $usuarioId)
                ->first();

            if (!$usuario || !$usuario->current_store) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não possui loja associada'
                ], 404);
            }
            
            // Validação básica
            if (!$request->has('descricao') || empty($request->input('descricao'))) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'A descrição é obrigatória',
                    'detalhes' => ['descricao' => ['O campo descrição é obrigatório']]
                ], 422);
            }

            \DB::beginTransaction();

            $descontoId = \DB::table('descontos_em_massa')->insertGetId([
                'ativo' => $request->input('ativo', true),
                'descricao' => $request->input('descricao'),
                'tipo_desconto' => $request->input('tipoDesconto'),
                'valor_desconto' => $request->input('valorDesconto'),
                'valor_minimo_produto' => $request->input('valorMinimoProduto', 0.00),
                'utilizacao_unica_por_cliente' => true,
                'publico_alvo' => $request->input('tipoClientes', 'qualquer'),
                'validade_inicio' => $request->input('limitarData') ? $request->input('dataInicio') : now(),
                'validade_fim' => $request->input('limitarData') ? $request->input('dataFim') : now()->addYears(10),
                'titulo_promocao' => $request->input('tituloPromocao', 'Desconto em Massa'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log após inserção na tabela principal
            \Log::info('Desconto em massa inserido com sucesso:', [
                'id' => $descontoId,
                'descricao' => $request->input('descricao')
            ]);

            // Estados
            $estados = $request->input('estadosSelecionados', []);
            foreach ($estados as $estado) {
                \DB::table('desconto_massa_estado')->insert([
                    'desconto_id' => $descontoId,
                    'estado_id' => $estado, // Se for ID, senão adapte para UF ou nome
                ]);
            }

            // Clientes
            if ($request->input('tipoClientes') === 'especificos') {
                $clientes = $request->input('clientesSelecionados', []);
                foreach ($clientes as $cliente) {
                    \DB::table('desconto_massa_cliente')->insert([
                        'desconto_id' => $descontoId,
                        'cliente_id' => $cliente['id'],
                    ]);
                }
            }

            \DB::commit();

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Desconto em Massa salvo com sucesso!',
                'id' => $descontoId
            ], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Erro ao salvar desconto em massa: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'dados' => $request->all()
            ]);
            
            return response()->json([
                'sucesso' => false,
                'erro' => 'Erro ao salvar desconto em massa',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }


    public function brinde_de_carrinho_index()
    {
        return view('desconto-progressivo.brinde-de-carrinho');
    }

    public function salvarBrindeCarrinho(Request $request)
    {
        try {
            $usuarioId = \Auth::id();
            if (!$usuarioId) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não autenticado'
                ], 401);
            }

            // Buscar informações do usuário e sua loja atual
            $usuario = \DB::table('users')
                ->select('id', 'current_store')
                ->where('id', $usuarioId)
                ->first();

            if (!$usuario || !$usuario->current_store) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'Usuário não possui loja associada'
                ], 404);
            }
            
            // Validação básica
            if (!$request->has('descricao') || empty($request->input('descricao'))) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'A descrição é obrigatória',
                    'detalhes' => ['descricao' => ['O campo descrição é obrigatório']]
                ], 422);
            }

            // Validação do valor mínimo
            if (!$request->has('valorMinimoCompra') || floatval($request->input('valorMinimoCompra')) <= 0) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'O valor mínimo de compra é obrigatório',
                    'detalhes' => ['valorMinimoCompra' => ['O campo valor mínimo de compra é obrigatório e deve ser maior que zero']]
                ], 422);
            }

            // Validação dos brindes
            if (!$request->has('brindesSelecionados') || !is_array($request->input('brindesSelecionados')) || count($request->input('brindesSelecionados')) === 0) {
                return response()->json([
                    'sucesso' => false,
                    'erro' => 'É necessário selecionar pelo menos um brinde',
                    'detalhes' => ['brindesSelecionados' => ['Selecione pelo menos um brinde para oferecer']]
                ], 422);
            }

            \DB::beginTransaction();

            // Preparar datas de validade
            $validadeInicio = $request->input('limitarData') ? $request->input('dataInicio') : now();
            $validadeFim = $request->input('limitarData') ? $request->input('dataFim') : now()->addYears(10);

            $brindeId = \DB::table('brindes_carrinho')->insertGetId([
                'ativo' => $request->input('ativo', true),
                'descricao' => $request->input('descricao'),
                'valor_minimo' => floatval($request->input('valorMinimoCompra')),
                'validade_inicio' => $validadeInicio,
                'validade_fim' => $validadeFim,
                'store_id' => $usuario->current_store,
                'created_by' => $usuarioId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Estados
            $estados = $request->input('estadosSelecionados', []);
            foreach ($estados as $estado) {
                \DB::table('brinde_carrinho_estado')->insert([
                    'brinde_id' => $brindeId,
                    'estado_id' => $estado,
                ]);
            }

            // Brindes
            $brindes = $request->input('brindesSelecionados', []);
            foreach ($brindes as $brinde) {
                \DB::table('brinde_carrinho_produto')->insert([
                    'brinde_id' => $brindeId,
                    'produto_id' => $brinde['id'],
                ]);
            }

            \DB::commit();

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Brinde no carrinho salvo com sucesso!',
                'id' => $brindeId
            ], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            
            return response()->json([
                'sucesso' => false,
                'erro' => 'Erro ao salvar brinde no carrinho',
                'detalhes' => $e->getMessage()
            ], 500);
        }
    }




    public function cupons_de_desconto_index()
    {
        return view('desconto-progressivo.cupons-de-desconto');
    }
}
