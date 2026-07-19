<form method="POST" action="{{ route('register') }}">
    @csrf

    <div>
        <label>Nom</label>
        <input 
            type="text" 
            name="name" 
            value="{{ old('name') }}" 
            required
        >
    </div>

    <div>
        <label>Email</label>
        <input 
            type="email" 
            name="email" 
            value="{{ old('email') }}" 
            required
        >
    </div>

    <div>
        <label>Mot de passe</label>
        <input 
            type="password" 
            name="password" 
            required
        >
    </div>

    <div>
        <label>Confirmation</label>
        <input 
            type="password" 
            name="password_confirmation" 
            required
        >
    </div>

    <button type="submit">Créer un compte</button>
</form>
