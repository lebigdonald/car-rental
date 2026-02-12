@php use Carbon\Carbon; @endphp
@extends('layouts.master')

@section('title', 'Historique')

@section('main')

    <div class="container">
        <div class="row row--grid">
            <!-- breadcrumb -->
            <div class="col-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb__item"><a href="{{ route('home.index') }}">Accueil</a></li>
                    <li class="breadcrumb__item breadcrumb__item--active">Historique</li>
                </ul>
            </div>
            <!-- end breadcrumb -->

            <!-- title -->
            <div class="col-12">
                <div class="main__title main__title--page">
                    <h1>Historique</h1>
                </div>
            </div>
            <!-- end title -->
        </div>

        <div class="row row--grid">
            <div class="col-12">
                <!-- content tabs -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                        <div class="row row--grid">
                            <div class="col-12">
                                <!-- cart -->
                                <div class="cart">
                                    <div class="cart__table-wrap">
                                        <div class="cart__table-scroll">
                                            <table class="cart__table">
                                                <thead>
                                                <tr>
                                                    <th>Voitures</th>
                                                    <th></th>
                                                    <th>Date de debut</th>
                                                    <th>Date de fin</th>
                                                    <th>Statut du paiement</th>
                                                    <th>Méthode de paiement</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach ($rents as $rent)
                                                    <tr>
                                                        <td>
                                                            <div class="cart__img">
                                                                <img src="{{ Storage::url($rent->car->image_url) }}"
                                                                     alt="">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('car.show', ['id' => $rent->car->id]) }}">{{ $rent->car->brand.' '.$rent->car->model }}</a>
                                                        </td>
                                                        <td>{{ Carbon::parse($rent->start_date)->format('d/m/Y') }}</td>
                                                        <td>{{ Carbon::parse($rent->end_date)->format('d/m/Y') }}</td>
                                                        <td>
                                                            @if($rent->payement_status == 'Payé')
                                                                <span class="badge" style="background-color: #28a745; color: white; padding: 5px 10px; border-radius: 15px;">Payé</span>
                                                            @elseif($rent->payement_status == 'En Attente')
                                                                <span class="badge" style="background-color: #ffc107; color: black; padding: 5px 10px; border-radius: 15px;">En attente</span>
                                                            @elseif($rent->payement_status == 'Annulé')
                                                                <span class="badge" style="background-color: #dc3545; color: white; padding: 5px 10px; border-radius: 15px;">Annulé</span>
                                                            @else
                                                                <span
                                                                    class="badge" style="background-color: #6c757d; color: white; padding: 5px 10px; border-radius: 15px;">{{ $rent->payement_status }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $rent->payement_method}}</td>
                                                        <td colspan="2">{{ number_format($rent->total_cost, 0, ',', ' ') }}
                                                            FCFA
                                                        </td>
                                                        <td>
                                                            @if($rent->payement_status == 'En Attente')
                                                                <form
                                                                    action="{{ route('rent.destroy', ['id' => $rent->id]) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Voulez-vous vraiment annuler cette location ?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-sm" style="background-color: #dc3545; border-color: #dc3545; color: white; border-radius: 15px;">
                                                                        Annuler
                                                                    </button>
                                                                </form>
                                                            @elseif($rent->payement_status == 'Payé')
                                                                <a href="{{ route('rent.invoice', ['id' => $rent->id]) }}" class="btn btn-primary btn-sm badge-primary" target="_blank">Facture</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end cart -->
                            </div>
                        </div>


                    </div>
                </div>
                <!-- end content tabs -->
            </div>
        </div>
    </div>

@endsection
