<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AplicativosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'XSS']);
    }

    /**
     * Display the applications page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Lista de aplicativos disponíveis
        $aplicativos = [
            [
                'id' => 1,
                'nome' => 'Destaque do Instagram',
                'descricao' => 'Transforme a gestão do seu negócio com uma visão 360° de todas as suas ferramentas em um único dashboard inteligente com IA.',
                'preco_mensal' => 49,
                'preco_anual' => 49,
                'desconto' => 77,
                'armazenamento' => '10GB',
                'armazenamento_adicional' => 'R$ 20,00 a cada 10 Gbs adicionais.',
                'status' => 'Ativo',
                'limitado' => false,
                'icone' => '🔗',
                'categoria' => 'instagram'
            ],
            [
                'id' => 2,
                'nome' => 'Widget do TikTok',
                'descricao' => 'Impulsione vendas com brindes no carrinho. Pague compras grátis com pontos e mais recursos.',
                'preco_mensal' => 49,
                'preco_anual' => 49,
                'desconto' => 77,
                'armazenamento' => null,
                'armazenamento_adicional' => null,
                'status' => 'Novo',
                'limitado' => true,
                'icone' => '📱',
                'categoria' => 'tiktok'
            ],
            [
                'id' => 3,
                'nome' => 'Widget do Instagram',
                'descricao' => 'Transforme a gestão do seu negócio com uma visão 360° de todas as suas ferramentas em um único dashboard inteligente com IA.',
                'preco_mensal' => 49,
                'preco_anual' => 49,
                'desconto' => 77,
                'armazenamento' => null,
                'armazenamento_adicional' => null,
                'status' => 'Novo',
                'limitado' => true,
                'icone' => '📷',
                'categoria' => 'instagram'
            ],
            [
                'id' => 4,
                'nome' => 'Dash',
                'descricao' => 'Transforme a gestão do seu negócio com uma visão 360° de todas as suas ferramentas em um único dashboard inteligente com IA.',
                'preco_mensal' => 49,
                'preco_anual' => 49,
                'desconto' => 77,
                'armazenamento' => '10GB',
                'armazenamento_adicional' => 'R$ 20,00 a cada 10 Gbs adicionais.',
                'status' => 'Novo',
                'limitado' => false,
                'icone' => '📊',
                'categoria' => 'dashboard'
            ]
        ];

        // Dados do combo especial
        $combo_especial = [
            'nome' => '+ Empreender',
            'descricao' => 'Informações combo',
            'preco_original' => 1272,
            'preco_promocional' => 297,
            'cobranca' => 'Cobrança Mensal',
            'desconto' => 77,
            'apps_inclusos' => 55
        ];

        // Banner principal
        $banner = [
            'titulo' => 'EMPREENDER PLUS',
            'subtitulo' => 'TUDO O QUE SUA LOJA PRECISA EM UM SÓ LUGAR',
            'descricao' => 'O Plus reúne todos os seus produtos da Empreender usando o mesmo login e senha. Todos os assinantes do plano completo ganham mais de 75% de desconto, além de dezenas de vantagens.',
            'video_url' => '#'
        ];

        return view('aplicativos.index', compact('aplicativos', 'combo_especial', 'banner'));
    }

    /**
     * Show details of a specific application.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        // Aqui você pode implementar a lógica para mostrar detalhes de um aplicativo específico
        return view('aplicativos.show', compact('id'));
    }

    /**
     * Subscribe to an application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request, $id)
    {
        // Aqui você pode implementar a lógica para assinar um aplicativo
        // Por exemplo, redirecionar para o gateway de pagamento
        
        return redirect()->route('aplicativos.index')
                         ->with('success', 'Assinatura realizada com sucesso!');
    }
} 