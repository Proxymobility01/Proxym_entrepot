@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    :root {
        --primary: #DCDB32;
        --primary-dark: #B9B82A;
        --primary-light: rgba(220, 219, 50, 0.1);
        --secondary: #101010;
        --tertiary: #F3F3F3;
        --background: #ffffff;
        --text: #101010;
        --sidebar: #F8F8F8;
    }

    /* Layout général */
    .main-content {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    /* En-tête de page */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .page-header h1 {
        margin: 0;
        font-weight: 600;
        color: var(--secondary);
        font-family: 'Orbitron', sans-serif;
    }

    /* Filtres */
    .filter-row {
        background-color: var(--background);
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.03);
    }

    #filterForm {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-item {
        margin-bottom: 0;
    }

    .filter-label {
        display: block;
        font-size: 0.875rem;
        margin-bottom: 5px;
        font-weight: 500;
        color: #555;
    }

    .filter-controls {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    /* Formulaires et contrôles */
    .form-control {
        width: 100%;
        height: 40px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(220, 219, 50, 0.25);
    }

    /* Boutons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .btn i {
        margin-right: 8px;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--secondary);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: #f3f3f3;
        color: #333;
        border: 1px solid #ddd;
    }

    .btn-secondary:hover {
        background-color: #e6e6e6;
    }

    .mr-2 {
        margin-right: 10px;
    }

    /* Table */
    .table-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 15px rgba(0,0,0,0.05);
        margin-bottom: 25px;
        overflow: hidden;
        position: relative;
    }

    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table th {
        padding: 15px;
        background-color: var(--primary);
        font-weight: 600;
        color: #444;
        text-align: left;
        border-bottom: 1px solid #ddd;
        position: sticky;
        top: 0;
        z-index: 10;
        font-family: 'Orbitron', sans-serif;
    }

    .custom-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .custom-table tr:hover {
        background-color: #f9f9f9;
    }

    /* Modal styles */
    .modal-custom {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        overflow-y: auto;
    }

    .modal-content-custom {
        position: relative;
        background-color: #fff;
        margin: 50px auto;
        width: 90%;
        max-width: 600px;
        border-radius: 12px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.15);
        animation: modalSlideDown 0.3s ease;
        overflow: hidden;
    }

    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 20px;
        border-bottom: 1px solid #eee;
        background-color: var(--tertiary);
    }

    .modal-title-custom {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--secondary);
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #666;
        line-height: 1;
        transition: color 0.2s;
    }

    .modal-close:hover {
        color: #333;
    }

    .modal-body-custom {
        padding: 20px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .modal-footer-custom {
        padding: 15px 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        background-color: #fafafa;
    }

    @keyframes modalSlideDown {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<div class="main-content">
    <!-- En-tête de page -->
    <div class="page-header">
        <h1>Historique des Transactions</h1>
        <button id="exportBtn" class="btn btn-primary">
            <i class="fas fa-download"></i> Exporter
        </button>
    </div>

    <!-- Filtres -->
    <div class="filter-row">
        <form id="filterForm" method="GET" action="{{ route('historiques.index') }}">
            <!-- Recherche par batterie -->
            <div class="filter-item">
                <label for="search" class="filter-label">Recherche par batterie</label>
                <input type="text" id="search" name="search" class="form-control" 
                    value="{{ $filters['search'] ?? '' }}" placeholder="ID de batterie">
            </div>

            <!-- Type de swap -->
            <div class="filter-item">
                <label for="type_swap" class="filter-label">Type de swap</label>
                <select name="type_swap" id="type_swap" class="form-control">
                    <option value="">Tous les swaps</option>
                    <option value="livraison" {{ ($filters['type_swap'] ?? '') == 'livraison' ? 'selected' : '' }}>Livraison</option>
                    <option value="retour" {{ ($filters['type_swap'] ?? '') == 'retour' ? 'selected' : '' }}>Retour</option>
                </select>
            </div>

            <!-- Date de début -->
            <div class="filter-item">
                <label for="date_debut" class="filter-label">Date de début</label>
                <input type="date" id="date_debut" name="date_debut" class="form-control" 
                    value="{{ $filters['date_debut'] ?? '' }}">
            </div>

            <!-- Date de fin -->
            <div class="filter-item">
                <label for="date_fin" class="filter-label">Date de fin</label>
                <input type="date" id="date_fin" name="date_fin" class="form-control" 
                    value="{{ $filters['date_fin'] ?? '' }}">
            </div>

            <!-- Boutons de contrôle -->
            <div class="filter-controls">
                <button type="button" id="resetFiltersBtn" class="btn btn-secondary mr-2">
                    <i class="fas fa-times"></i> Réinitialiser
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Appliquer
                </button>
            </div>
        </form>
    </div>

    <!-- Tableau des résultats -->
    <div id="tableContainer" class="table-container">
        @include('historiques.partials.table')
    </div>

    <!-- Modal pour afficher les batteries -->
    <div id="batteriesModal" class="modal-custom">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3 class="modal-title-custom">Liste des batteries</h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body-custom">
                <!-- Le contenu sera inséré dynamiquement -->
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary modal-close-btn">Fermer</button>
            </div>
        </div>
    </div>

    <!-- Modal pour afficher les détails d'une transaction -->
    <div id="transactionModal" class="modal-custom">
        <div class="modal-content-custom">
            <div class="modal-header-custom">
                <h3 class="modal-title-custom">Détails de la Transaction</h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body-custom">
                <!-- Le contenu sera inséré dynamiquement -->
            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn btn-secondary modal-close-btn">Fermer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Variables pour le script
    var exportUrl = "{{ route('historiques.export') }}";
    var transactionUrl = "{{ route('historiques.show', '') }}";

    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        const resetBtn = document.getElementById('resetFiltersBtn');
        const exportBtn = document.getElementById('exportBtn');
        const batteriesModal = document.getElementById('batteriesModal');
        const transactionModal = document.getElementById('transactionModal');
        const tableContainer = document.getElementById('tableContainer');
        
        initFilterEvents();
        initExportEvent();
        initModalEvents();
        
        // Initialiser les événements pour les filtres
        function initFilterEvents() {
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    applyFilters();
                });
            }
            
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    filterForm.reset();
                    applyFilters();
                });
            }
        }
        
        // Initialiser l'événement d'exportation
        function initExportEvent() {
            if (exportBtn) {
                exportBtn.addEventListener('click', function() {
                    const formData = new FormData(filterForm);
                    const queryParams = new URLSearchParams(formData).toString();
                    
                    // Animation du bouton
                    animateButton(this);
                    
                    // Rediriger vers la route d'export avec les filtres
                    window.location.href = exportUrl + '?' + queryParams;
                });
            }
        }
        
        // Initialiser les événements pour les modals
        function initModalEvents() {
            // Fermeture des modals
            document.querySelectorAll('.modal-close, .modal-close-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    closeModal(batteriesModal);
                    closeModal(transactionModal);
                });
            });
            
            // Fermer le modal en cliquant à l'extérieur
            window.addEventListener('click', function(e) {
                if (e.target === batteriesModal) {
                    closeModal(batteriesModal);
                }
                if (e.target === transactionModal) {
                    closeModal(transactionModal);
                }
            });
            
            // Écouter la touche Echap pour fermer les modals
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal(batteriesModal);
                    closeModal(transactionModal);
                }
            });
        }
        
        // Appliquer les filtres via AJAX
        function applyFilters() {
            if (!filterForm) return;
            
            const formData = new FormData(filterForm);
            const queryParams = new URLSearchParams(formData).toString();
            
            // Mettre à jour l'URL avec les paramètres de filtre
            const newUrl = window.location.pathname + '?' + queryParams;
            window.history.pushState({path: newUrl}, '', newUrl);
            
            // Afficher l'indicateur de chargement
            showLoading(tableContainer);
            
            // Faire la requête AJAX
            fetch(window.location.pathname + '?' + queryParams + '&ajax=1', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau lors de la récupération des données');
                }
                return response.text();
            })
            .then(html => {
                // Mettre à jour le contenu
                tableContainer.innerHTML = html;
                
                // Initialiser la pagination dans le nouveau contenu
                initPagination();
                
                // Masquer le chargement
                hideLoading(tableContainer);
            })
            .catch(error => {
                console.error('Erreur lors du chargement des données:', error);
                hideLoading(tableContainer);
                tableContainer.innerHTML = ` 
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        Une erreur est survenue lors du chargement des données. Veuillez réessayer.
                    </div>
                `;
            });
        }
        
        // Fonction pour afficher l'indicateur de chargement
        function showLoading(container) {
            let overlay = container.querySelector('.loading-overlay');
            
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'loading-overlay';
                overlay.innerHTML = '<div class="loader"></div>';
                
                const position = window.getComputedStyle(container).position;
                if (position === 'static') {
                    container.style.position = 'relative';
                }
                
                container.appendChild(overlay);
            } else {
                overlay.style.display = 'flex';
            }
        }
        
        // Masquer l'indicateur de chargement
        function hideLoading(container) {
            const overlay = container.querySelector('.loading-overlay');
            if (overlay) {
                overlay.style.display = 'none';
            }
        }

        // Animer un bouton
        function animateButton(button) {
            button.classList.add('btn-animate');
            button.style.transform = 'scale(0.95)';
            setTimeout(() => {
                button.style.transform = 'scale(1)';
                button.classList.remove('btn-animate');
            }, 150);
        }
    });
</script>
@endsection
