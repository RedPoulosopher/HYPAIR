<a href="/{{ $uid }}/entite/evenement/{{ $slug }}" class="event-card card">
  <h4>{{ $title }} <span>• {{ $entite }}</span></h4>

  @php
  setlocale(LC_TIME, 'fr_FR.UTF-8','fra'); 
  //ucwords pour avoir les majuscules au début des mots
  //utf_8 sinon le mois avec des accents (fevrier, aout, decembre) passent pas
  //strftime pour garder uniquement la date (et pas le time)
  $end_date   = ucwords(utf8_encode(strftime("%A %d %B", strtotime($end))));
  $start_date = ucwords(utf8_encode(strftime("%A %d %B", strtotime($start))));
  @endphp

  @if($start_date == $end_date)
    <p>{{ $start_date }}</p>
  @else
    <p>Du {{ $start_date }}<br>
    au {{ $end_date }}</p>
  @endif
  
</a>