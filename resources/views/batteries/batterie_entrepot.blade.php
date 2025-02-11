@extends('layouts.app')

@section('content')
<!-- ================ Swap Users List ================= -->
<div class="details">
    <div class="recentOrders">
        <div class="cardHeader">
            <h2>Listes des Batteries</h2>
            <a href="#" class="btn">Voir Tout</a>
        </div>

        <table id="example" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mac_id</th>
                    <th>Fabriquant</th>
                    <th>Date d'ajout dans le système</th>
                </tr>
            </thead>

            <tbody>
                @foreach($batteries as $batterie)
                    <tr>
                        <td>{{ $batterie->batteryValide->batterie_unique_id }}</td>
                        <td>{{ $batterie->batteryValide->mac_id }} </td>
                        <td>{{ $batterie->batteryValide->fabriquant }}</td>
                        <td>{{ $batterie->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Inclusion des fichiers JS -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.1/js/dataTables.bootstrap5.js"></script>

<script>
    // Initialisation de DataTables
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endsection
