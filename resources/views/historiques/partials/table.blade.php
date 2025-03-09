{{-- historiques/partials/table.blade.php --}}

@if(isset($historique) && count($historique) > 0)
    <table class="custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Batteries</th>
                <th>Utilisateur</th>
                <th>Date & Heure</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historique as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>
                        <span class="badge {{ $transaction->type_swap == 'livraison' ? 'badge-livraison' : 'badge-retour' }}">
                            {{ ucfirst($transaction->type_swap) }}
                        </span>
                    </td>
                    <td>
                        <div class="batteries-info">
                            @if(count($transaction->bat_sortante) > 0)
                                <button type="button" class="btn btn-sm btn-secondary" 
                                    onclick="showBatteries('sortante', {{ json_encode($transaction->bat_sortante) }})">
                                    Sortantes
                                    <span class="badge-count">{{ count($transaction->bat_sortante) }}</span>
                                </button>
                            @endif
                            
                            @if(count($transaction->bat_entrante) > 0)
                                <button type="button" class="btn btn-sm btn-secondary" 
                                    onclick="showBatteries('entrante', {{ json_encode($transaction->bat_entrante) }})">
                                    Entrantes
                                    <span class="badge-count">{{ count($transaction->bat_entrante) }}</span>
                                </button>
                            @endif
                        </div>
                    </td>
                    <td>{{ $transaction->user_name }}</td>
                    <td>{{ $transaction->formatted_date }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" 
                            onclick="showTransactionDetails({{ $transaction->id }})">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="pagination-container">
        {{ $historique->appends(request()->except('page'))->links() }}
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fas fa-search"></i>
        </div>
        <h3>Aucune transaction trouvée</h3>
        <p>Modifiez vos critères de recherche ou réinitialisez les filtres.</p>
    </div>
    
    <style>
        .empty-state {
            padding: 40px 20px;
            text-align: center;
        }
        
        .empty-state-icon {
            font-size: 3rem;
            color: #ddd;
            margin-bottom: 15px;
        }
        
        .empty-state h3 {
            margin-bottom: 10px;
            color: #666;
        }
        
        .empty-state p {
            color: #888;
        }
    </style>
@endif