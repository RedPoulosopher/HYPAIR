@extends('template')
@section('contenu')
    <br>
    <div class="container">
        <div class="row card text-white bg-dark">
            <h4 class="card-header">Ajoutez_une_association </h4>
            <div class="card-body">
                <form action="{{ route('documentation.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="IDasso" class="form-control  @error('IDasso') is-invalid @enderror" name="IDasso" id="IDasso" placeholder="ID asso" value="{{ old('IDasso') }}">
                        @error('IDasso')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <textarea class="form-control  @error('confidentialite') is-invalid @enderror" name="confidentialite" id="confidentialite" placeholder="Niveau de confidentialité">{{ old('confidentialite') }}</textarea>
                        @error('confidentialite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    <div class="form-group">
                        <textarea class="form-control  @error('titre') is-invalid @enderror" name="titre" id="titre" placeholder="titre">{{ old('titre') }}</textarea>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <div class="form-group">
                        <textarea class="form-control  @error('contenu') is-invalid @enderror" name="contenu" id="contenu" placeholder="contenu">{{ old('contenu') }}</textarea>
                        @error('contenu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <div class="form-group">
                        <input type="checkbox" class="form-control  @error('mise_en_avant') is-invalid @enderror" name="mise_en_avant" id="mise_en_avant" placeholder="mise_en_avant"/>
                        @error('mise_en_avant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <div class="form-group">
                        <textarea class="form-control  @error('debut_mise_en_avant') is-invalid @enderror" name="debut_mise_en_avant" id="debut_mise_en_avant" placeholder="debut_mise_en_avant">{{ old('debut_mise_en_avant') }}</textarea>
                        @error('debut_mise_en_avant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <div class="form-group">
                        <textarea class="form-control  @error('fin_mise_en_avant') is-invalid @enderror" name="fin_mise_en_avant" id="fin_mise_en_avant" placeholder="fin_mise_en_avant">{{ old('fin_mise_en_avant') }}</textarea>
                        @error('fin_mise_en_avant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-secondary">Envoyer !</button>
                </form>
            </div>
        </div>
    </div>
@endsection