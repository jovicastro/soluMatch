<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SoluMatch</title>
    <link rel="stylesheet" href="../CSS/trabalhos.css">
</head>
<body>

<header>

 <!-- Barra de navegação principal -->
        <nav class="navbar">
            <!-- Logo/nome da empresa -->
            <a href="../templates/trabalhos.html">
                <div class="logo">
                    <img src="../misc/logo2.png" width="50vh">
                    <h2>Solu<span>Match<span></h2>
                </div>
            </a>
            <!-- --------------------------------------------------------------------------------------- -->
<!-- Ícone de perfil -->
<div class="dropdown">
    <div class="profile-icon" id="profileIcon">
        <img class="profile"src="../misc/Perfil_imagem.jpg" alt="">
    </div>
  
    <!-- Menu dropdown -->
    <div class="dropdown-menu" id="dropdownMenu">
      <div>
        <strong>Seja bem vindo ao Solu<span>Match</span></strong>
        <p>Na SoluMatch, você tem acesso a oportunidades reais com empresas. 
            São projetos diversos que valorizam seu talento e muitas vezes com uma remuneração que 
            faz a diferença.
        </p>
        <a href="../templates/quero_trabalhar.html"><button class="highlight-btn">Começar</button></a>
      </div>
  
      <div class="section">
        <a href="#">Meu perfil</a>
      </div>
  
      <div class="section">
        <strong>Contratar</strong>
        <a href="#">Encontre freelancers</a>
        <button class="purple-btn">Publique um projeto</button>
      </div>
  
      <div class="section">
        <strong>Ajuda</strong>
        <a href="#">Como funciona</a>
        <a href="../templates/ajuda.html">Obter Suporte</a>
      </div>
  
  
      <div class="section">
        <a href="#">Sair</a>
      </div>
    </div>
  </div>
            <!-- --------------------------------------------------------------------------------------- -->
            <!-- <li class="dropdown">
                
            <a href="#" data-toggle="dropdown" >
            <img src="../misc/Perfil_imagem.jpg" alt="" class="profile">
            </a>
            <ul>


            </ul>
            </li> -->
</header>

<div class="workana-jobs-container">
    <aside class="jobs-filter-sidebar">
        <div class="filter-section">
            <h3 class="filter-title">Categorias</h3>
            <ul class="filter-list">
                <li class="filter-item active">Programação</li>
                <li class="filter-item">Design</li>
                <li class="filter-item">Marketing</li>
                <li class="filter-item">Redação</li>
            </ul>
        </div>
        
        <div class="filter-section">
            <h3 class="filter-title">Tipo de Job</h3>
            <div class="filter-checkbox">
                <input type="checkbox" id="fixed-price" checked>
                <label for="fixed-price">Preço Fixo</label>
            </div>
            <div class="filter-checkbox">
                <input type="checkbox" id="hourly-rate">
                <label for="hourly-rate">Por Hora</label>
            </div>
        </div>
    </aside>
    
    <main class="jobs-main-content">
        <div class="jobs-search-bar">
            <input type="text" class="search-input" placeholder="Pesquisar Trabalhos...">
            <button class="search-button">Buscar</button>
        </div>
        
        <div class="jobs-sorting">
            <span class="sorting-label">Ordenar por:</span>
            <select class="sorting-select">
                <option>Mais recentes</option>
                <option>Menor orçamento</option>
                <option>Maior orçamento</option>
            </select>
        </div>
        
        <div class="jobs-list">
            <!-- Jobs serão renderizados aqui via JavaScript -->
        </div>
        
        <div class="jobs-pagination">
            <button class="pagination-button active">1</button>
            <button class="pagination-button">2</button>
            <button class="pagination-button">3</button>
            <span class="pagination-ellipsis">...</span>
            <button class="pagination-button">10</button>
            <button class="pagination-next">Próximo &raquo;</button>
        </div>
    </main>
</div>

<!-- Modal de Detalhes do Job -->
<div class="job-modal" id="jobModal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2 class="modal-title" id="modalJobTitle">Título da Vaga</h2>
        <div class="modal-budget" id="modalJobBudget">R$ 0,00</div>
        
        <div class="modal-section">
            <h3>Descrição do Projeto</h3>
            <p id="modalJobDescription">Descrição do projeto...</p>
        </div>
        
        <div class="modal-section">
            <h3>Tecnologias Requeridas</h3>
            <div class="modal-skills" id="modalJobSkills">
                <!-- Skills serão inseridas aqui via JavaScript -->
            </div>
        </div>
        
        <div class="modal-footer">
            <span class="job-posted" id="modalJobPosted">Postado há 0 dias</span>
            <span class="job-proposals" id="modalJobProposals">0 propostas</span>
        </div>
        
        <button class="apply-button">Enviar Proposta</button>
    </div>
</div>

<script src="../JavaScript/trabalhos.js"></script>
<script src="../JavaScript/dropdown_perfil.js"></script>
</body>
</html>