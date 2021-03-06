@layout('elements.main')
@section('content')
<h3>Тест</h3>
<p>Последние ID:
    @foreach( $chain as $code )
        <a href="?object_id={{ $code }}"><code>{{ $code }}</code></a>&emsp;
    @endforeach
    <form method="post">
        <button class="btn btn-primary" formaction="?object_id=random"> Случайный филиал</button>
    </form>
    </p><form class="form-inline" method="GET">
    <input type="text" name="object_id" class="span3" placeholder="Введите ID" >
    <button type="submit" class="btn">Искать</button>
    <p class="hide">Такого ID нет в базе данных.</p>
</form>
    @if ( $type )
        Это - {{ $type }}
    @endif
    <pre>
        {{ !empty( $raw_entity ) ? print_r( (array)$raw_entity ) : 'Пусто'  }}
    </pre>

<br><br>

@endsection
