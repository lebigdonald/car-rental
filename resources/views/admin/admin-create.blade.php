@extends('admin.layouts.master')

@section('title', "Ajouter un utilisateur")

@section('main')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Ajouter un utilisateur</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Nouvel utilisateur</li>
        </ol>

        <div class="mb-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.store') }}" method="POST">
                        @csrf
                        <div class="form-group row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Nom d'utilisateur :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="fullname" class="col-sm-3 col-form-label">Nom complet :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="email" class="col-sm-3 col-form-label">Email :</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password" class="col-sm-3 col-form-label">Mot de passe :</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">Confirmer le mot de passe :</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Annuler</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
