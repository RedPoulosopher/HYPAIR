 <x-layout>
     <article>
         <h1>{ !! $projet->title !!}</h1>

        <a> par {{$projet->chef_projet}} <a href="/associations/{{ $projet->association->nom}}">{{ $projet->association->titre }}</a>
         <div>
             {!! $projet->description_courte !!}
        </div>
</article>
</x-layout>