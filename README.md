<h1 align="center" style="font-weight: bold;">Simulador de Crédito Backend API 💻</h1>

<p align="center">
 <a href="#tech">Tecnologias</a> • 
 <a href="#started">Vamos Começar</a> • 
 <a href="#routes">API Endpoints</a> •
</p>

<p align="center">
    <b>API de Backend para simulação de crédito, permitindo aos usuários visualizar as condições de pagamento com base no valor solicitado, taxa de juros, e prazo de pagamento.</b>
</p>

<h2>📐 Estrutura do Projeto e Arquitetura</h2>

<p>Este projeto segue uma estrutura baseada nos princípios <strong>SOLID</strong>, organizando o código em camadas bem definidas para facilitar a manutenção, a escalabilidade. Abaixo estão os principais componentes:</p>

<ul>
  <li><strong>Controller</strong>: Responsável por receber as requisições HTTP e encaminhar as operações necessárias para os <em>services</em>.</li>
  <li><strong>Service</strong>: Contém a lógica de negócios principal e faz a ponte entre o <em>controller</em> e o <em>repository</em>.</li>
  <li><strong>Repository</strong>: Gerencia a comunicação com o banco de dados, encapsulando consultas e operações de persistência de dados.</li>
  <li><strong>DTO (Data Transfer Object)</strong>: Utilizado para transferir dados de maneira estruturada e tipada entre camadas.</li>
  <li><strong>Request</strong>: Define as regras de validação para os dados de entrada, garantindo que apenas dados válidos cheguem aos <em>services</em>.</li>
  <li><strong>Response</strong>: Formata as respostas de forma consistente antes de serem enviadas para o cliente.</li>
  <li><strong>Collection</strong>: Facilita a manipulação e formatação de coleções de dados que precisam ser retornadas em listas ou agrupamentos específicos.</li>
</ul>

<h3>📌 Por que essa estrutura fechada é vantajosa?</h3>

<p>Essa organização modular e orientada aos princípios <strong>SOLID</strong> permite uma série de vantagens, entre elas:</p>

<ul>
  <li><strong>Facilidade de manutenção</strong>: Com responsabilidades bem definidas em cada camada, é mais simples localizar e corrigir problemas sem afetar outras partes do sistema.</li>
  <li><strong>Escalabilidade</strong>: A divisão em camadas facilita a expansão do sistema, permitindo adicionar ou modificar funcionalidades de forma independente.</li>
  <li><strong>Modularidade</strong>: Cada camada executa uma função específica, o que promove a reutilização de código e facilita a implementação de testes unitários isolados.</li>
  <li><strong>Segurança e consistência</strong>: O uso de <em>DTO</em>, <em>Request</em>, e <em>Response</em> ajuda a validar e estruturar os dados, reduzindo a chance de inconsistências e aumentando a segurança dos dados transferidos.</li>
</ul>

<p>Essa abordagem orientada aos princípios SOLID resulta em um sistema mais robusto e preparado para crescer com novas demandas e requisitos, mantendo o código limpo e fácil de entender.</p>

<h2 id="technologies">💻 Tecnologias</h2>

<ul>
  <li>PHP</li>
  <li>Laravel</li>
  <li>POSTGRESQL</li>
</ul>

<h2 id="started">🚀 Vamos Começar</h2>

<h3>Pré-requisitos</h3>

<ul>
  <li>PHP 8+</li>
  <li>Composer</li>
  <li>MySQL</li>
</ul>

<h3>Clone</h3>

<pre><code>git clone https://github.com/herongs/api-simulador-credito.git</code></pre>

<h3>Configuração do Projeto</h3>

<ol>
  <li>Copie o arquivo <code>.env.example</code> para <code>.env</code> e configure as variáveis de ambiente:</li>
</ol>

<pre><code>DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
MAIL_HOST=smtp.seuprovedor.com
MAIL_PORT=587
MAIL_USERNAME=seu_email
MAIL_PASSWORD=sua_senha
</code></pre>

<ol start="2">
  <li>Instale as dependências do projeto:</li>
</ol>

<pre><code>composer install</code></pre>

<ol start="3">
  <li>Gere a chave da aplicação Laravel:</li>
</ol>

<pre><code>php artisan key:generate</code></pre>

<ol start="4">
  <li>Execute as migrações para criar as tabelas necessárias no banco de dados:</li>
</ol>

<pre><code>php artisan migrate</code></pre>

<ol start="5">
  <li>Execute o seeder para popular o banco de dados:</li>
</ol>

<pre><code>php artisan db:seed</code></pre>

<ol start="6">
  <li>Inicie o servidor:</li>
</ol>

<pre><code>php artisan serve</code></pre>

<h2 id="routes">📍 API Endpoints</h2>

<table>
  <tr>
    <th>Rota</th>
    <th>Descrição</th>
  </tr>
  <tr>
    <td><kbd>POST /simulacao-credito</kbd></td>
    <td>Responsável por criar uma simulação de crédito com os dados do usuário e retornar o valor total, parcelas, e juros totais. <a href="#post-simular-detail">[request details]</a></td>
  </tr>
</table>

<h3 id="post-simular-detail">POST /simular</h3>

<p><strong>REQUEST</strong></p>

<pre><code>{
 "valor_emprestimo": 5000,
 "data_nascimento": "1980-01-01",
 "prazo_meses": 24,
 "taxa_variavel": 0.03, // opcional
 "email": "usuario@example.com" // opcional
}
</code></pre>

<p><strong>RESPONSE</strong></p>

<pre><code>{
 "valor_total": 5600,
 "valor_parcelas": 233.33,
 "total_juros": 600
}
</code></pre>

<h2>📑 Documentação de Cálculo</h2>

<p>O cálculo das parcelas fixas segue a fórmula PMT de amortização:</p>
<ul>
  <li><strong>PMT</strong>: Pagamento mensal</li>
  <li><strong>PV</strong>: Valor presente (empréstimo)</li>
  <li><strong>r</strong>: Taxa de juros mensal (taxa anual / 12)</li>
  <li><strong>n</strong>: Número total de pagamentos (em meses)</li>
</ul>

<hr>

