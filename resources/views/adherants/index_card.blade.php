@extends('layouts.app')

@section('titre', 'Entités')
@pushonce('styles')
    @vite([
        'resources/css/adherants/index_card.scss',
        'resources/css/jstable.scss',
    ])
@endpushonce

@section('content')
<style>
/* Grille */
.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(430px, 1fr));
    gap: 25px;
    margin-top: 25px;
}

/* Carte principale */
.card-item {
    background: #1c1f2b;
    border: 1px solid #303444;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
}

.card-item:hover {
    transform: translateY(-5px);
    border-color: #6366f1;
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.15);
}

/* Lien */
.card-content-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

/* Aperçu */
.card-preview {
    padding: 20px;
    background: linear-gradient(135deg, #252a3a, #191d29);
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 170px;
}

/* Informations */
.card-info {
    padding: 18px 20px 15px;
}

.card-info h3 {
    font-size: 17px;
    font-weight: 700;
    color: #f1f3f9;
    margin: 12px 0 6px;
}

.card-info p {
    font-size: 13px;
    color: #929bb0;
    margin: 0;
    line-height: 1.5;
}

/* Badge */
.card-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 600;
    color: #4adea5;
    background: rgba(34, 197, 136, 0.12);
    border: 1px solid rgba(34, 197, 136, 0.15);
    padding: 5px 10px;
    border-radius: 20px;
}

.status-dot {
    width: 7px;
    height: 7px;
    background: #4adea5;
    border-radius: 50%;
    box-shadow: 0 0 8px rgba(74, 222, 165, 0.6);
}

/* Actions */
.card-actions {
    padding: 12px 20px 18px;
    border-top: 1px solid #303444;
    display: flex;
    justify-content: flex-end;
}

.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 16px;
    border-radius: 8px;
    background: rgba(99, 102, 241, 0.15);
    border: 1px solid rgba(99, 102, 241, 0.25);
    color: #a5b4fc;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-edit:hover {
    background: #6366f1;
    border-color: #6366f1;
    color: white;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

/* État vide */
.empty-cards {
    text-align: center;
    padding: 50px 20px;
    background: #1c1f2b;
    border: 1px dashed #3b4154;
    border-radius: 15px;
    margin-top: 20px;
}

.empty-cards i {
    font-size: 40px;
    color: #737e9a;
    margin-bottom: 15px;
}

.empty-cards h3 {
    color: #e4e7ef;
    font-size: 18px;
}

.empty-cards p {
    color: #929bb0;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 576px) {
    .cards-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<main id="main-content">
	<section>
		<h1><span class="icon-security-safe" title="page accessible aux administrateurs"></span> Cartes</h1>

		<a href="{{ route('create_card',[$entite->uid]) }}" class="bouton tertiaire icon-security-safe" id="bouton-creer">Créer une carte</a>

        <div class="section-content">
            <h2>Cartes actuelles :</h2>

            @if(isset($cardModels) && count($cardModels) > 0)

                <div class="cards-grid">
                    @foreach ($cardModels as $cardModel)

                        <div class="card-item">

                            <a href="{{-- route('list_adherants_card',[$entite->uid,$cardModel->uid]) --}}"
                            class="card-content-link">

                                <div class="card-preview">
                                    @include("components.card_view_model", [
                                        $cardModel,
                                        "card_username" => "Nombre de possesseurs : 5"
                                    ])
                                </div>

                                <div class="card-info">
                                    <span class="card-status">
                                        <span class="status-dot"></span>
                                        Carte active
                                    </span>

                                    <h3>{{ $cardModel->name ?? 'Modèle de carte' }}</h3>

                                    <p>Consulter les adhérents possédant cette carte.</p>
                                </div>

                            </a>

                            <div class="card-actions">
                                <a href="{{ route('edit_card', [$entite->uid, $cardModel->uid]) }}"
                                class="btn-edit">
                                    <i class="fas fa-pen"></i>
                                    Modifier
                                </a>
                            </div>

                        </div>

                    @endforeach
                </div>

            @else
                <div class="empty-cards">
                    <i class="fas fa-id-card"></i>
                    <h3>Aucune carte disponible</h3>
                    <p>Vous n'avez pas encore créé de modèle de carte.</p>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection