@extends('layouts.master')

@section('title', 'A propos')

@section('main')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="main__title main__title--first">
                <h2>À propos de CarRental</h2>
            </div>
        </div>
        <div class="col-12">
            <p class="section__text">
                Bienvenue chez CarRental, votre partenaire de confiance pour la location de voitures. Nous sommes dédiés à fournir une expérience de location de voiture sans tracas, abordable et agréable pour tous nos clients. Que vous ayez besoin d'une voiture pour un voyage d'affaires, des vacances en famille ou simplement pour vous déplacer en ville, nous avons le véhicule qu'il vous faut.
            </p>
            <p class="section__text">
                Notre flotte diversifiée comprend des modèles récents, allant des voitures économiques aux SUV spacieux et aux véhicules de luxe. Nous nous engageons à maintenir nos voitures dans un état impeccable pour assurer votre sécurité et votre confort.
            </p>
        </div>
    </div>

    <div class="row row--grid">
        <div class="col-12">
            <div class="main__title">
                <h2>Notre Mission</h2>
            </div>
        </div>
        <div class="col-12">
            <p class="section__text">
                Notre mission est de simplifier la mobilité en offrant des solutions de location de voitures flexibles et accessibles. Nous croyons que louer une voiture devrait être simple, transparent et sans surprise. C'est pourquoi nous offrons des tarifs compétitifs, une réservation en ligne facile et un service client exceptionnel.
            </p>
        </div>
    </div>

    <section class="row row--grid">
        <div class="col-12">
            <div class="main__title">
                <h2>Pourquoi nous choisir ?</h2>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="step1">
                <span class="step1__icon step1__icon--pink">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Zm0-12.5a4.5,4.5,0,1,0,4.5,4.5A4.5051,4.5051,0,0,0,12,7.5Zm0,7a2.5,2.5,0,1,1,2.5-2.5A2.50295,2.50295,0,0,1,12,14.5Z"/></svg>
                </span>
                <h3 class="step1__title">Large Sélection</h3>
                <p class="step1__text">Choisissez parmi une vaste gamme de véhicules adaptés à tous vos besoins et budgets.</p>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="step1">
                <span class="step1__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,2A10,10,0,1,0,22,12,10.01114,10.01114,0,0,0,12,2Zm0,18a8,8,0,1,1,8-8A8.00917,8.00917,0,0,1,12,20Zm1-13H11a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Zm-2,4h2a1,1,0,0,0,0-2H11a1,1,0,0,0,0,2Zm2,4H11a1,1,0,0,0,0,2h2a1,1,0,0,0,0-2Z"/></svg>
                </span>
                <h3 class="step1__title">Prix Transparents</h3>
                <p class="step1__text">Pas de frais cachés. Ce que vous voyez est ce que vous payez.</p>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="step1">
                <span class="step1__icon step1__icon--purple">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12,2A10,10,0,0,0,2,12a9.89,9.89,0,0,0,2.26,6.33l-2,2a1,1,0,0,0-.21,1.09A1,1,0,0,0,3,22h9A10,10,0,0,0,12,2Zm0,18H5.41l.93-.93a1,1,0,0,0,0-1.41A8,8,0,1,1,12,20Z"/></svg>
                </span>
                <h3 class="step1__title">Support 24/7</h3>
                <p class="step1__text">Notre équipe est disponible à tout moment pour vous assister en cas de besoin.</p>
            </div>
        </div>
    </section>
</div>
@endsection
