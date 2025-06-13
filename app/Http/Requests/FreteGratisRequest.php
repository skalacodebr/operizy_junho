<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class FreteGratisRequest extends FormRequest
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
            'ativo' => 'required|boolean',
            'descricaoCupom' => 'required|string|max:255',
            'tipoDesconto' => 'required|in:porcentagem,valor_fixo',
            'porcentagemDesconto' => 'required_if:tipoDesconto,porcentagem|nullable|numeric|min:0.01|max:100',
            'valorFixoDesconto' => 'required_if:tipoDesconto,valor_fixo|nullable|numeric|min:0.01',
            'condicaoAplicacao' => 'required|in:sempre,valor_minimo,quantidade_minima',
            'valorMinimoProduto' => 'required_if:condicaoAplicacao,valor_minimo|nullable|numeric|min:0',
            'quantidadeMinimaProdutos' => 'required_if:condicaoAplicacao,quantidade_minima|nullable|integer|min:1',
            'limitarData' => 'required|boolean',
            'dataInicio' => 'nullable|date|required_if:limitarData,true',
            'dataFim' => 'nullable|date|required_if:limitarData,true|after:dataInicio',
            'estadosSelecionados' => 'nullable|array',
            'estadosSelecionados.*' => 'string|in:Acre,Alagoas,Amapá,Amazonas,Bahia,Ceará,Distrito Federal,Espírito Santo,Goiás,Maranhão,Mato Grosso,Mato Grosso do Sul,Minas Gerais,Pará,Paraíba,Paraná,Pernambuco,Piauí,Rio de Janeiro,Rio Grande do Norte,Rio Grande do Sul,Rondônia,Roraima,Santa Catarina,São Paulo,Sergipe,Tocantins',
            'tipoClientes' => 'required|in:todos,especificos',
            'clientesSelecionados' => 'nullable|array',
            'clientesSelecionados.*.id' => 'integer|exists:customers,id',
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
            'descricaoCupom.required' => 'A descrição do cupom é obrigatória.',
            'descricaoCupom.max' => 'A descrição do cupom não pode ter mais de 255 caracteres.',
            'ativo.required' => 'É necessário definir se o frete grátis está ativo.',
            'ativo.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
            'tipoDesconto.required' => 'O tipo de desconto é obrigatório.',
            'tipoDesconto.in' => 'O tipo de desconto deve ser porcentagem ou valor fixo.',
            'porcentagemDesconto.required_if' => 'A porcentagem de desconto é obrigatória quando o tipo é porcentagem.',
            'porcentagemDesconto.numeric' => 'A porcentagem de desconto deve ser um número.',
            'porcentagemDesconto.min' => 'A porcentagem de desconto deve ser maior que zero.',
            'porcentagemDesconto.max' => 'A porcentagem de desconto não pode ser maior que 100%.',
            'valorFixoDesconto.required_if' => 'O valor fixo de desconto é obrigatório quando o tipo é valor fixo.',
            'valorFixoDesconto.numeric' => 'O valor fixo de desconto deve ser um número.',
            'valorFixoDesconto.min' => 'O valor fixo de desconto deve ser maior que zero.',
            'condicaoAplicacao.required' => 'A condição de aplicação é obrigatória.',
            'condicaoAplicacao.in' => 'A condição de aplicação deve ser sempre, valor mínimo ou quantidade mínima.',
            'valorMinimoProduto.required_if' => 'O valor mínimo do produto é obrigatório quando a condição é valor mínimo.',
            'valorMinimoProduto.numeric' => 'O valor mínimo do produto deve ser um número.',
            'valorMinimoProduto.min' => 'O valor mínimo do produto não pode ser negativo.',
            'quantidadeMinimaProdutos.required_if' => 'A quantidade mínima de produtos é obrigatória quando a condição é quantidade mínima.',
            'quantidadeMinimaProdutos.integer' => 'A quantidade mínima de produtos deve ser um número inteiro.',
            'quantidadeMinimaProdutos.min' => 'A quantidade mínima de produtos deve ser pelo menos 1.',
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
            'descricaoCupom' => 'descrição do cupom',
            'ativo' => 'status ativo',
            'tipoDesconto' => 'tipo de desconto',
            'porcentagemDesconto' => 'porcentagem de desconto',
            'valorFixoDesconto' => 'valor fixo de desconto',
            'condicaoAplicacao' => 'condição de aplicação',
            'valorMinimoProduto' => 'valor mínimo do produto',
            'quantidadeMinimaProdutos' => 'quantidade mínima de produtos',
            'limitarData' => 'limitar por data',
            'dataInicio' => 'data de início',
            'dataFim' => 'data de fim',
            'estadosSelecionados' => 'estados selecionados',
            'tipoClientes' => 'tipo de clientes',
            'clientesSelecionados' => 'clientes selecionados',
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
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Converter strings vazias para null onde apropriado
        $this->merge([
            'porcentagemDesconto' => $this->input('porcentagemDesconto') ?: null,
            'valorFixoDesconto' => $this->input('valorFixoDesconto') ?: null,
            'valorMinimoProduto' => $this->input('valorMinimoProduto') ?: null,
            'quantidadeMinimaProdutos' => $this->input('quantidadeMinimaProdutos') ?: null,
            'dataInicio' => $this->input('dataInicio') ?: null,
            'dataFim' => $this->input('dataFim') ?: null,
        ]);
    }
} 