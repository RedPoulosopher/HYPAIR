<x-layout> 
    @foreach($projets as $projet)
    <article>
        <h1>
            <a href="/projets/{{ $projet->id}}">
                {{!! $projet->title !!}}
            </a>
        </h1>
        <div>
            {{$projet->description_courte }}
        </div>
    </article>
</x-layout>