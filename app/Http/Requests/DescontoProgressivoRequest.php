<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class DescontoProgressivoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:255',
            'ativo' => 'required|boolean',
            'valorMinimo' => 'nullable|numeric|min:0',
            'limitarData' => 'required|boolean',
            'dataInicio' => 'nullable|date|required_if:limitarData,true',
            'dataFim' => 'nullable|date|required_if:limitarData,true|after:dataInicio',
            'estadosSelecionados' => 'nullable|array',
            'estadosSelecionados.*' => 'string|in:Acre,Alagoas,Amapá,Amazonas,Bahia,Ceará,Distrito Federal,Espírito Santo,Goiás,Maranhão,Mato Grosso,Mato Grosso do Sul,Minas Gerais,Pará,Paraíba,Paraná,Pernambuco,Piauí,Rio de Janeiro,Rio Grande do Norte,Rio Grande do Sul,Rondônia,Roraima,Santa Catarina,São Paulo,Sergipe,Tocantins',
            'tipoClientes' => 'required|in:todos,especificos',
            'clientesSelecionados' => 'nullable|array',
            'clientesSelecionados.*.id' => 'integer|exists:customers,id',
            'regrasDesconto' => 'required|array|min:1',
            'regrasDesconto.*.desconto' => 'required|numeric|min:0.01|max:100',
            'regrasDesconto.*.quantidade' => 'required|integer|min:1',
            'todosProdutos' => 'required|boolean',
            'tipoAplicacao' => 'required|in:produtos,categorias,marcas',
            'produtosSelecionados' => 'nullable|array',
            'produtosSelecionados.*.id' => 'integer|exists:products,id',
            'permitirOutrasPromocoes' => 'required|boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'O título da promoção é obrigatório.',
            'titulo.max' => 'O título não pode ter mais de 255 caracteres.',
            'ativo.required' => 'É necessário definir se o desconto está ativo.',
            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
            'valorMinimo.numeric' => 'O valor mínimo deve ser um número.',
            'valorMinimo.min' => 'O valor mínimo não pode ser negativo.',
            'limitarData.required' => 'É necessário definir se deve limitar por data.',
            'limitarData.boolean' => 'O campo limitar data deve ser verdadeiro ou falso.',
            'dataInicio.required_if' => 'A data de início é obrigatória quando limitar por data está ativo.',
            'dataInicio.date' => 'A data de início deve ser uma data válida.',
            'dataFim.required_if' => 'A data de fim é obrigatória quando limitar por data está ativo.',
            'dataFim.date' => 'A data de fim deve ser uma data válida.',
            'dataFim.after' => 'A data de fim deve ser posterior à data de início.',
            'estadosSelecionados.array' => 'Os estados selecionados devem ser uma lista.',
            'estadosSelecionados.*.in' => 'Estado brasileiro inválido selecionado.',
            'tipoClientes.required' => 'É necessário definir o tipo de clientes.',
            'tipoClientes.in' => 'Tipo de clientes deve ser "todos" ou "especificos".',
            'clientesSelecionados.array' => 'Os clientes selecionados devem ser uma lista.',
            'clientesSelecionados.*.id.exists' => 'Cliente selecionado não encontrado.',
            'regrasDesconto.required' => 'É necessário adicionar pelo menos uma regra de desconto.',
            'regrasDesconto.min' => 'É necessário ter pelo menos uma regra de desconto.',
            'regrasDesconto.*.desconto.required' => 'A porcentagem de desconto é obrigatória.',
            'regrasDesconto.*.desconto.numeric' => 'A porcentagem de desconto deve ser um número.',
            'regrasDesconto.*.desconto.min' => 'A porcentagem de desconto deve ser maior que zero.',
            'regrasDesconto.*.desconto.max' => 'A porcentagem de desconto não pode ser maior que 100%.',
            'regrasDesconto.*.quantidade.required' => 'A quantidade mínima é obrigatória.',
            'regrasDesconto.*.quantidade.integer' => 'A quantidade deve ser um número inteiro.',
            'regrasDesconto.*.quantidade.min' => 'A quantidade mínima deve ser pelo menos 1.',
            'todosProdutos.required' => 'É necessário definir se aplica para todos os produtos.',
            'todosProdutos.boolean' => 'O campo todos os produtos deve ser verdadeiro ou falso.',
            'tipoAplicacao.required' => 'É necessário definir o tipo de aplicação.',
            'tipoAplicacao.in' => 'Tipo de aplicação deve ser "produtos", "categorias" ou "marcas".',
            'produtosSelecionados.array' => 'Os produtos selecionados devem ser uma lista.',
            'produtosSelecionados.*.id.exists' => 'Produto selecionado não encontrado.',
            'permitirOutrasPromocoes.required' => 'É necessário definir se permite outras promoções.',
            'permitirOutrasPromocoes.boolean' => 'O campo permitir outras promoções deve ser verdadeiro ou falso.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'titulo' => 'título da promoção',
            'ativo' => 'status ativo',
            'valorMinimo' => 'valor mínimo do produto',
            'limitarData' => 'limitar por data',
            'dataInicio' => 'data de início',
            'dataFim' => 'data de fim',
            'estadosSelecionados' => 'estados selecionados',
            'tipoClientes' => 'tipo de clientes',
            'clientesSelecionados' => 'clientes selecionados',
            'regrasDesconto' => 'regras de desconto',
            'todosProdutos' => 'todos os produtos',
            'tipoAplicacao' => 'tipo de aplicação',
            'produtosSelecionados' => 'produtos selecionados',
            'permitirOutrasPromocoes' => 'permitir outras promoções'
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Validação customizada: se não for todos os produtos, deve ter produtos selecionados
            if (!$this->input('todosProdutos') && 
                (!$this->has('produtosSelecionados') || empty($this->input('produtosSelecionados')))) {
                $validator->errors()->add(
                    'produtosSelecionados', 
                    'Selecione pelo menos um produto ou marque "Aplicar para todos os produtos".'
                );
            }

            // Validação customizada: se tipo clientes for específicos, deve ter clientes selecionados
            if ($this->input('tipoClientes') === 'especificos' && 
                (!$this->has('clientesSelecionados') || empty($this->input('clientesSelecionados')))) {
                $validator->errors()->add(
                    'clientesSelecionados', 
                    'Selecione pelo menos um cliente ou escolha "Todos os Clientes".'
                );
            }

            // Validação customizada: verificar se não há regras duplicadas por quantidade
            $regras = $this->input('regrasDesconto', []);
            $quantidades = [];
            
            foreach ($regras as $index => $regra) {
                $quantidade = $regra['quantidade'] ?? 0;
                
                if (in_array($quantidade, $quantidades)) {
                    $validator->errors()->add(
                        "regrasDesconto.{$index}.quantidade", 
                        'Já existe uma regra para esta quantidade de itens.'
                    );
                }
                
                $quantidades[] = $quantidade;
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Converter strings vazias para null onde apropriado
        $this->merge([
            'valorMinimo' => $this->input('valorMinimo') ?: null,
            'dataInicio' => $this->input('dataInicio') ?: null,
            'dataFim' => $this->input('dataFim') ?: null,
        ]);
    }
} 