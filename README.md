# Simulador de Crédito Backend API 💻

<p><strong>API de Backend para simulação de crédito, permitindo aos usuários visualizar as condições de pagamento com base no valor solicitado, taxa de juros e prazo de pagamento.</strong></p>

<hr>

<h2>📐 Estrutura do Projeto e Arquitetura</h2>

<p>Este projeto segue os princípios <strong>SOLID</strong> e organiza o código em camadas bem definidas para facilitar a manutenção e escalabilidade. Abaixo, temos os principais componentes:</p>

<ul>
  <li><strong>Controller</strong>: Recebe as requisições HTTP e delega as operações necessárias para os <strong>services</strong>.</li>
  <li><strong>Service</strong>: Contém a lógica de negócios principal e faz a interface entre o <strong>controller</strong> e o <strong>repository</strong>.</li>
  <li><strong>Repository</strong>: Gerencia a comunicação com o banco de dados, encapsulando consultas e operações de persistência.</li>
  <li><strong>DTO (Data Transfer Object)</strong>: Usado para transferir dados de forma estruturada entre as camadas.</li>
  <li><strong>Request</strong>: Define regras de validação para garantir que apenas dados válidos sejam processados pelos <strong>services</strong>.</li>
  <li><strong>Response</strong>: Formata as respostas de forma consistente antes de enviá-las ao cliente.</li>
  <li><strong>Collection</strong>: Facilita a manipulação e formatação de coleções de dados que precisam ser retornadas em listas ou agrupamentos específicos.</li>
</ul>

<p>Essa estrutura proporciona uma série de vantagens, como:</p>

<ul>
  <li><strong>Facilidade de manutenção</strong>: Com responsabilidades bem definidas, é simples corrigir problemas sem afetar outras partes do sistema.</li>
  <li><strong>Escalabilidade</strong>: Permite adicionar ou modificar funcionalidades de forma independente.</li>
  <li><strong>Modularidade</strong>: Promove a reutilização de código e facilita a implementação de testes unitários isolados.</li>
  <li><strong>Segurança e Consistência</strong>: Uso de DTO, Request e Response para garantir a validação e estruturação adequadas dos dados.</li>
</ul>

<hr>

<h2>💻 Tecnologias</h2>

<ul>
  <li><strong>PHP</strong></li>
  <li><strong>Laravel</strong></li>
  <li><strong>PostgreSQL</strong></li>
</ul>

<hr>

<h2>🚀 Instalação</h2>

<h3>Pré-requisitos</h3>

<p>Certifique-se de ter as seguintes ferramentas instaladas:</p>

<ul>
  <li><strong>PHP 8+</strong></li>
  <li><strong>Composer</strong></li>
  <li><strong>MySQL</strong></li>
</ul>

<h3>Como configurar o projeto</h3>

<ol>
  <li>Clone o repositório:</li>
  <pre><code>git clone https://github.com/herongs/api-simulador-credito.git</code></pre>
  
  <li>Copie o arquivo <code>.env.example</code> para <code>.env</code> e configure as variáveis de ambiente:</li>
  <pre><code>
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
MAIL_HOST=smtp.seuprovedor.com
MAIL_PORT=587
MAIL_USERNAME=seu_email
MAIL_PASSWORD=sua_senha
  </code></pre>
  
  <li>Instale as dependências do projeto:</li>
  <pre><code>composer install</code></pre>
  
  <li>Gere a chave da aplicação Laravel:</li>
  <pre><code>php artisan key:generate</code></pre>
  
  <li>Execute as migrações para criar as tabelas no banco de dados:</li>
  <pre><code>php artisan migrate</code></pre>
  
  <li>Popule o banco de dados com os dados iniciais:</li>
  <pre><code>php artisan db:seed</code></pre>
  
  <li>Inicie o servidor:</li>
  <pre><code>php artisan serve</code></pre>
</ol>

<hr>

<h2>📍 API Endpoints</h2>

<h3>📌 POST /simulacao-credito</h3>

<p>Cria uma simulação de crédito com os dados do usuário e retorna o valor total, parcelas e juros totais.</p>

<h4>Exemplo de requisição:</h4>
<pre><code>
{
  "loan_amount": 5000,
  "payment_date": 24,
  "birth_date": "1980-01-01"
}
</code></pre>

<h4>Resposta:</h4>
<pre><code>
{
  "total_payment": 5104.83,
  "monthly_payment": 212.70,
  "total_interest": 104.83
}
</code></pre>

<h4>Exemplo com tipo de juros variável:</h4>
<pre><code>
{
  "loan_amount": 5000,
  "payment_date": 24,
  "birth_date": "1980-01-01",
  "interest_type": "VARIAVEL"
}
</code></pre>

<h4>Resposta:</h4>
<pre><code>
{
  "total_payment": 5571.66,
  "monthly_payment": 232.15,
  "total_interest": 571.66
}
</code></pre>

<h4>Exemplo com envio de email:</h4>
<pre><code>
{
  "loan_amount": 5000,
  "payment_date": 24,
  "birth_date": "1980-01-01",
  "interest_type": "VARIAVEL",
  "email": "teste@email.com"
}
</code></pre>

<h4>Resposta:</h4>
<pre><code>
{
  "total_payment": 5571.66,
  "monthly_payment": 232.15,
  "total_interest": 571.66
}
</code></pre>

<h3>📌 POST /simulacao-credito-cambio</h3>

<p>Cria uma simulação de crédito com os dados do usuário, retornando o valor total, parcelas e juros totais com a conversão da moeda.</p>

<h4>Exemplo de requisição:</h4>
<pre><code>
{
  "loan_amount": 5000,
  "payment_date": 24,
  "birth_date": "1980-01-01",
  "target_currency": "USD"
}
</code></pre>

<h4>Resposta:</h4>
<pre><code>
{
  "total_payment": 889.26,
  "monthly_payment": 31.05,
  "total_interest": 18.26
}
</code></pre>

<hr>

<h2>📑 Documentação de Cálculo</h2>

<p>A simulação de crédito utiliza a fórmula de <strong>amortização PMT</strong> para calcular o valor das parcelas fixas:</p>

<ul>
  <li><strong>PMT</strong>: Pagamento mensal</li>
  <li><strong>PV</strong>: Valor presente (empréstimo)</li>
  <li><strong>r</strong>: Taxa de juros mensal (taxa anual / 12)</li>
  <li><strong>n</strong>: Número total de pagamentos (em meses)</li>
</ul>

<h3>Faixa de Juros</h3>

<p>A simulação considera duas taxas de juros:</p>

<ul>
  <li><strong>Taxa fixa</strong>, baseada na faixa etária do cliente:
    <ul>
      <li>Ate 25 anos: 5% ao ano</li>
      <li>De 26 a 40 anos: 3% ao ano</li>
      <li>De 41 a 60 anos: 2% ao ano</li>
      <li>Acima de 60 anos: 4% ao ano</li>
    </ul>
  </li>
  <li><strong>Taxa variável</strong>, baseada na taxa Selic vigente, permitindo ajustes conforme as condições econômicas.</li>
</ul>

<h3>Conversão de Moeda</h3>

<p>O sistema também permite a conversão do valor do empréstimo para outras moedas, como o dólar (USD). Ao informar a sigla da moeda desejada, o sistema converte o valor do empréstimo para a moeda selecionada, ajustando a simulação conforme a taxa de câmbio atual.</p>

<hr>

<h2>📧 Exemplo de Email de Confirmação</h2>

<p>Caso o usuário forneça um email na requisição, um email de confirmação será enviado com os detalhes da simulação. As imagens a seguir ilustram as duas opções possíveis de simulação:</p>

 ![](assets/Simulacao.png) 
[](assets/Simulacao-Cambio.png) 

<img src="assets/Simulacao-Cambio.png" alt="Texto Alternativo">
<img src="assets/Simulacao.png" alt="Texto Alternativo">

<hr>

