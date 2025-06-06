document.addEventListener('DOMContentLoaded', function() {
    // Dados mockados de jobs
    const jobsData = [
       {
            id: 1,
            title: "Desenvolvedor Front-end React",
            budget: 2500,
            description: "Precisamos de um desenvolvedor front-end com experiência em React para criar interfaces responsivas e modernas para nosso e-commerce. O profissional irá trabalhar em conjunto com o time de UX/UI e backend para implementar novas funcionalidades.",
            skills: ["React", "JavaScript", "CSS", "TypeScript"],
            posted: "2 dias atrás",
            proposals: 15,
            category: "Programação",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 2,
            title: "Designer de Logo Profissional",
            budget: 800,
            description: "Procuramos designer para criar identidade visual completa para nova marca de cosméticos veganos. Serão necessários: logo, paleta de cores, tipografia e diretrizes de aplicação.",
            skills: ["Adobe Illustrator", "Branding", "Photoshop"],
            posted: "1 dia atrás",
            proposals: 8,
            category: "Design",
            type: "fixed-price",
            highlighted: true
        },
        {
            id: 3,
            title: "Copywriter para Artigos",
            budget: 1200,
            description: "Necessário redator para produção de 10 artigos sobre tecnologia com 1.500 palavras cada. Tópicos incluem: inteligência artificial, blockchain e desenvolvimento web. Conhecimento técnico é diferencial.",
            skills: ["Redação", "SEO", "Tecnologia"],
            posted: "5 horas atrás",
            proposals: 3,
            category: "Redação",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 4,
            title: "Social Media Manager",
            budget: 45,
            description: "Gerenciamento de redes sociais com criação de conteúdo para Instagram e LinkedIn. Planejamento de posts, interação com seguidores e relatórios de desempenho mensais.",
            skills: ["Instagram", "LinkedIn", "Marketing Digital"],
            posted: "3 dias atrás",
            proposals: 12,
            category: "Marketing",
            type: "hourly-rate",
            highlighted: false
        },
        
        // Novos jobs (12)
        {
            id: 5,
            title: "Desenvolvedor Back-end Node.js",
            budget: 3200,
            description: "Procuramos desenvolvedor back-end para implementar APIs RESTful usando Node.js e Express. Integração com banco de dados MongoDB e sistema de autenticação JWT.",
            skills: ["Node.js", "Express", "MongoDB", "API REST"],
            posted: "1 dia atrás",
            proposals: 9,
            category: "Programação",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 6,
            title: "UX/UI Designer para App Mobile",
            budget: 1800,
            description: "Designer para criar interface e experiência de usuário para aplicativo de delivery. Deverá entregar wireframes, protótipos e guia de estilo.",
            skills: ["Figma", "UI Design", "UX Research", "Prototipagem"],
            posted: "4 dias atrás",
            proposals: 7,
            category: "Design",
            type: "fixed-price",
            highlighted: true
        },
        {
            id: 7,
            title: "Redator Técnico para Documentação",
            budget: 1500,
            description: "Redator para criar documentação técnica de software. Experiência com Markdown e conhecimento básico de programação são necessários.",
            skills: ["Redação Técnica", "Markdown", "Git", "Documentação"],
            posted: "6 horas atrás",
            proposals: 2,
            category: "Redação",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 8,
            title: "Especialista em Google Ads",
            budget: 55,
            description: "Profissional para gerenciar campanhas no Google Ads para e-commerce de moda feminina. Meta: aumentar conversões em 20% no próximo trimestre.",
            skills: ["Google Ads", "Analytics", "ROI", "PPC"],
            posted: "2 dias atrás",
            proposals: 11,
            category: "Marketing",
            type: "hourly-rate",
            highlighted: false
        },
        {
            id: 9,
            title: "Desenvolvedor Full Stack",
            budget: 4200,
            description: "Desenvolvedor full stack para projeto de 3 meses. Front-end em React e back-end em Django. Experiência com Docker é diferencial.",
            skills: ["React", "Django", "Python", "Docker"],
            posted: "1 hora atrás",
            proposals: 5,
            category: "Programação",
            type: "fixed-price",
            highlighted: true
        },
        {
            id: 10,
            title: "Ilustrador Digital para Livro Infantil",
            budget: 2000,
            description: "Ilustrador para criar 15 ilustrações coloridas para livro infantil. Estilo cartoon e cores vibrantes. Prazo de 4 semanas.",
            skills: ["Illustrator", "Procreate", "Ilustração Digital", "Design"],
            posted: "3 dias atrás",
            proposals: 6,
            category: "Design",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 11,
            title: "Tradutor Inglês-Português",
            budget: 30,
            description: "Tradutor para material técnico de TI (20.000 palavras). Prazo de 2 semanas. Experiência com glossários técnicos é essencial.",
            skills: ["Tradução", "Inglês", "Português", "TI"],
            posted: "Ontem",
            proposals: 4,
            category: "Redação",
            type: "hourly-rate",
            highlighted: false
        },
        {
            id: 12,
            title: "Gerente de Tráfego",
            budget: 3500,
            description: "Profissional para gerenciar todo o tráfego pago da empresa (Google Ads, Meta Ads, TikTok). Relatórios semanais e otimização constante.",
            skills: ["Meta Ads", "Google Ads", "TikTok Ads", "Analytics"],
            posted: "5 dias atrás",
            proposals: 8,
            category: "Marketing",
            type: "fixed-price",
            highlighted: true
        },
        {
            id: 13,
            title: "Desenvolvedor Flutter",
            budget: 2800,
            description: "Desenvolver aplicativo cross-platform usando Flutter. Integração com API existente e publicação nas lojas de aplicativos.",
            skills: ["Flutter", "Dart", "Firebase", "API"],
            posted: "Ontem",
            proposals: 7,
            category: "Programação",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 14,
            title: "Designer de Apresentações",
            budget: 600,
            description: "Criar deck de slides profissional para pitch de startup. 20 slides com design moderno e alinhado à identidade visual da marca.",
            skills: ["PowerPoint", "Keynote", "Design", "Apresentações"],
            posted: "8 horas atrás",
            proposals: 3,
            category: "Design",
            type: "fixed-price",
            highlighted: false
        },
        {
            id: 15,
            title: "Revisor de Textos Acadêmicos",
            budget: 25,
            description: "Revisor para tese de doutorado (80 páginas). Ajustes de formatação ABNT, gramática e coerência textual. Prazo de 1 semana.",
            skills: ["Revisão", "ABNT", "Gramática", "Acadêmico"],
            posted: "Hoje",
            proposals: 1,
            category: "Redação",
            type: "hourly-rate",
            highlighted: true
        },
        {
            id: 16,
            title: "Especialista em SEO",
            budget: 3800,
            description: "Otimização SEO para site de e-commerce (500 produtos). Inclui pesquisa de palavras-chave, meta tags e conteúdo otimizado.",
            skills: ["SEO", "Google Analytics", "Keyword Research", "E-commerce"],
            posted: "4 dias atrás",
            proposals: 9,
            category: "Marketing",
            type: "fixed-price",
            highlighted: false
        }
    ];

    // Elementos DOM
    const DOM = {
        jobsList: document.querySelector('.jobs-list'),
        searchInput: document.querySelector('.search-input'),
        searchButton: document.querySelector('.search-button'),
        sortingSelect: document.querySelector('.sorting-select'),
        filterItems: document.querySelectorAll('.filter-item'),
        filterCheckboxes: document.querySelectorAll('.filter-checkbox input'),
        pagination: document.querySelector('.jobs-pagination'),
        modal: document.getElementById('jobModal'),
        closeModal: document.querySelector('.close-modal')
    };

    // Estado da aplicação
    const state = {
        currentPage: 1,
        jobsPerPage: 5,
        activeCategory: 'Todos',
        activeFilters: {
            type: ['fixed-price', 'hourly-rate']
        },
        sortBy: 'recent',
        searchTerm: ''
    };

    // Inicialização
    init();

    function init() {
        renderJobs();
        setupEventListeners();
        renderPagination();
    }

    // Configura eventos
    function setupEventListeners() {
        // Busca
        DOM.searchButton.addEventListener('click', handleSearch);
        DOM.searchInput.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') handleSearch();
        });

        // Ordenação
        DOM.sortingSelect.addEventListener('change', (e) => {
            state.sortBy = e.target.value.toLowerCase().replace(' ', '-');
            renderJobs();
        });

        // Filtros de categoria
        DOM.filterItems.forEach(item => {
            item.addEventListener('click', () => {
                DOM.filterItems.forEach(i => i.classList.remove('active'));
                item.classList.add('active');
                state.activeCategory = item.textContent;
                state.currentPage = 1;
                renderJobs();
                renderPagination();
            });
        });

        // Filtros de tipo
        DOM.filterCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const type = checkbox.id.replace('-', '_');
                if (checkbox.checked) {
                    if (!state.activeFilters.type.includes(type)) {
                        state.activeFilters.type.push(type);
                    }
                } else {
                    state.activeFilters.type = state.activeFilters.type.filter(t => t !== type);
                }
                state.currentPage = 1;
                renderJobs();
                renderPagination();
            });
        });

        // Paginação
        DOM.pagination.addEventListener('click', handlePaginationClick);

        // Modal
        DOM.closeModal.addEventListener('click', () => {
            DOM.modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === DOM.modal) {
                DOM.modal.style.display = 'none';
            }
        });
    }

    // Renderiza jobs na página
    function renderJobs() {
        const filteredJobs = getFilteredJobs();
        const startIdx = (state.currentPage - 1) * state.jobsPerPage;
        const jobsToShow = filteredJobs.slice(startIdx, startIdx + state.jobsPerPage);

        DOM.jobsList.innerHTML = jobsToShow.map(job => `
            <article class="job-card ${job.highlighted ? 'highlighted' : ''}" data-job-id="${job.id}">
                <div class="job-header">
                    <h2 class="job-title">${job.title}</h2>
                    <span class="job-budget">${job.type === 'hourly-rate' ? `R$ ${job.budget}/hora` : `R$ ${job.budget.toFixed(2).replace('.', ',')}`}</span>
                </div>
                <p class="job-description">${job.description}</p>
                <div class="job-skills">
                    ${job.skills.map(skill => `<span class="skill-tag">${skill}</span>`).join('')}
                </div>
                <div class="job-footer">
                    <span class="job-posted">Postado ${job.posted}</span>
                    <span class="job-proposals">${job.proposals} propostas</span>
                </div>
            </article>
        `).join('');

        // Adiciona event listeners para os novos cards
        document.querySelectorAll('.job-card').forEach(card => {
            card.addEventListener('click', function(e) {
                const jobId = parseInt(this.getAttribute('data-job-id'));
                const job = jobsData.find(j => j.id === jobId);
                
                if (job) {
                    document.getElementById('modalJobTitle').textContent = job.title;
                    document.getElementById('modalJobBudget').textContent = 
                        job.type === 'hourly-rate' ? `R$ ${job.budget}/hora` : `R$ ${job.budget.toFixed(2).replace('.', ',')}`;
                    document.getElementById('modalJobDescription').textContent = job.description;
                    
                    const skillsContainer = document.getElementById('modalJobSkills');
                    skillsContainer.innerHTML = job.skills.map(skill => 
                        `<span class="skill-tag">${skill}</span>`
                    ).join('');
                    
                    document.getElementById('modalJobPosted').textContent = `Postado ${job.posted}`;
                    document.getElementById('modalJobProposals').textContent = `${job.proposals} propostas`;
                    
                    DOM.modal.style.display = 'block';
                }
            });
        });

        updateJobsCount(filteredJobs.length);
    }

    // ... (mantenha as outras funções como getFilteredJobs, handleSearch, etc.)

    // Filtra e ordena jobs
    function getFilteredJobs() {
        let filtered = [...jobsData];

        // Filtro por categoria
        if (state.activeCategory !== 'Todos') {
            filtered = filtered.filter(job => job.category === state.activeCategory);
        }

        // Filtro por tipo
        filtered = filtered.filter(job => state.activeFilters.type.includes(job.type));

        // Filtro por busca
        if (state.searchTerm) {
            filtered = filtered.filter(job => 
                job.title.toLowerCase().includes(state.searchTerm) ||
                job.description.toLowerCase().includes(state.searchTerm) ||
                job.skills.some(skill => skill.toLowerCase().includes(state.searchTerm))
            );
        }

        // Ordenação
        switch (state.sortBy) {
            case 'menor-orçamento':
                filtered.sort((a, b) => a.budget - b.budget);
                break;
            case 'maior-orçamento':
                filtered.sort((a, b) => b.budget - a.budget);
                break;
            default: // mais recentes
                filtered.sort((a, b) => {
                    // Lógica simplificada para ordenar por data postada
                    const daysA = parseInt(a.posted) || 0;
                    const daysB = parseInt(b.posted) || 0;
                    return daysA - daysB;
                });
        }

        return filtered;
    }

    // Atualiza contador de jobs
    function updateJobsCount(count) {
        const counter = document.querySelector('.jobs-count') || document.createElement('div');
        counter.className = 'jobs-count';
        counter.textContent = `${count} ${count === 1 ? 'job encontrado' : 'jobs encontrados'}`;
        
        if (!document.querySelector('.jobs-count')) {
            DOM.jobsList.insertAdjacentElement('beforebegin', counter);
        }
    }

    // Renderiza paginação
    function renderPagination() {
        const filteredJobs = getFilteredJobs();
        const totalPages = Math.ceil(filteredJobs.length / state.jobsPerPage);
        
        if (totalPages <= 1) {
            DOM.pagination.style.display = 'none';
            return;
        }
        
        DOM.pagination.style.display = 'flex';
        let paginationHTML = '';
        
        // Botões de página
        for (let i = 1; i <= totalPages; i++) {
            if (i <= 3 || i > totalPages - 2 || Math.abs(i - state.currentPage) <= 1) {
                paginationHTML += `<button class="pagination-button ${i === state.currentPage ? 'active' : ''}">${i}</button>`;
            } else if (paginationHTML.slice(-1) !== '...') {
                paginationHTML += `<span class="pagination-ellipsis">...</span>`;
            }
        }
        
        // Botão próximo
        if (state.currentPage < totalPages) {
            paginationHTML += `<button class="pagination-next">Próximo &raquo;</button>`;
        }
        
        DOM.pagination.innerHTML = paginationHTML;
    }

    // Manipuladores de eventos
    function handleSearch() {
        state.searchTerm = DOM.searchInput.value.trim().toLowerCase();
        state.currentPage = 1;
        renderJobs();
        renderPagination();
    }

    function handlePaginationClick(e) {
        if (e.target.classList.contains('pagination-button')) {
            if (e.target.textContent === '...') return;
            state.currentPage = parseInt(e.target.textContent);
            renderJobs();
            updateActivePaginationButton();
        } else if (e.target.classList.contains('pagination-next')) {
            state.currentPage++;
            renderJobs();
            renderPagination();
        }
    }

    // Atualiza botão ativo na paginação
    function updateActivePaginationButton() {
        document.querySelectorAll('.pagination-button').forEach(button => {
            button.classList.toggle('active', parseInt(button.textContent) === state.currentPage);
        });
    }

    // Adiciona transição suave ao carregar jobs
    DOM.jobsList.style.transition = 'opacity 0.3s ease';
    DOM.jobsList.style.opacity = '0';
    setTimeout(() => {
        DOM.jobsList.style.opacity = '1';
    }, 300);
});