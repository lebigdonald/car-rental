@php use Carbon\Carbon; @endphp
@extends('admin.layouts.master')

@section('title', 'Locations')

@section('main')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Liste des locations</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Locations</li>
            </ol>
            <!-- <div class="card mb-4">
                <div class="card-body">
                    Ici vous pouvez voir toute les voitures de notre parking.
                </div>
            </div>-->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="mb-4">
                {{--
                <div>
                    <a class="btn btn-primary m-3" href="{{ route('admin.rent.index') }}"
                       role="button">Ajouter</a>
                </div>
                --}}
                <div>
                    <table class="table table-hover table-responsive">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Debut</th>
                            <th>Fin</th>
                            <th>Coût total</th>
                            <th>Statut du payement</th>
                            <th>Méthode de payement</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($rents as $rent)
                            <tr>
                                <td>{{ $rent->id }}</td>
                                <td>{{ Carbon::parse($rent->start_date)->format('d/m/Y') }}</td>
                                <td>{{ Carbon::parse($rent->end_date)->format('d/m/Y') }}</td>
                                <td>{{ number_format($rent->total_cost, 0, ',', ' ') }} FCFA</td>
                                <td>
                                    @if($rent->payement_status == 'Payé')
                                        <span class="badge badge-success">Payé</span>
                                    @elseif($rent->payement_status == 'En Attente')
                                        <span class="badge badge-warning">En attente</span>
                                    @elseif($rent->payement_status == 'Annulé')
                                        <span class="badge badge-danger">Annulé</span>
                                    @else
                                        <span
                                            class="badge badge-default">{{ $rent->payement_status }}</span>
                                    @endif
                                </td>
                                <td>{{ $rent->payement_method }}</td>
                                <td>
                                    <div class="dropdown open">
                                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            Options
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                   href="{{ route('admin.rent.show', ['id' => $rent->id]) }}">Voir</a>
                                            </li>
                                            @if($rent->payement_status == 'En Attente')
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{ route('admin.rent.edit', ['id' => $rent->id]) }}">Modifier</a>
                                                </li>
                                                <li>
                                                    <button type="button" class="dropdown-item"
                                                            onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette location?')) { document.getElementById('delete-form').submit(); }">
                                                        Supprimer
                                                    </button>
                                                    <form id="delete-form"
                                                          action="{{ route('admin.rent.destroy', ['id' => $rent->id]) }}"
                                                          method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $rents->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection
