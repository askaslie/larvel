@layout('elements.main')
@section('content')

   @foreach( $filials as $filial )
        <h4> {{ $filial->info->name }}</h4><br>
        <h5>Адрес:</h5> {{ $filial->info->address }} <br>
        <div>
            <h5>Телефоны:</h5>
            @foreach ($filial->info->contacts[0]->contacts as $contact )
                {{ $contact->type == 'phone' ? '&nbsp;&nbsp;&nbsp;' . $contact->value . ( isset($contact->comment) ? '(' . $contact->comment .')' : ' ' ) . '<br>'  : '' }}
            @endforeach
        </div>
        <div>
            <h5>email:</h5>
            @foreach ($filial->info->contacts[0]->contacts as $contact )
                {{ $contact->type == 'email' ? $contact->value . '<br>' : ''; }}
            @endforeach
        </div>
        <div>
            <h5>website:</h5>
            @foreach ($filial->info->contacts[0]->contacts as $contact )
                {{ $contact->type == 'website' ? $contact->alias . '<br>': ''; }}
            @endforeach
        </div>
   @endforeach
@endsection



