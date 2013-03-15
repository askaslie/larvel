@layout('elements.main')
@section('content')

Запросов выполнено за сегодня : {{ $options->querry_count}} <br>
Активных заданий : {{ $tasks_active}} <br>
Всего записей в базе : {{ $total_entries }} <br> <br> <br>
<a href="{{ URL::to_action('daemons.filials_parser')}}" target="_blank">Запустить парсер принудительно</a>
<br><br>
<form method="post" name="options">
    <?php echo Form::label('total_querry_limit', 'Лимит запросов'); ?>
    <?php echo Form::text('total_querry_limit', $options->total_querry_limit); ?>
    <?php echo Form::label('api_url', 'Ссылка на API'); ?>
    <?php echo Form::text('api_url', $options->api_url); ?>
    <?php echo Form::label('api_key', 'Токен 2gis'); ?>
    <?php echo Form::text('api_key', $options->api_key); ?>
    <?php echo Form::label('api_version', 'Версия API'); ?>
    <?php echo Form::text('api_version', $options->api_version); ?>
    <br>
    <input class="btn btn-primary" type="submit" value="Сохранить">
</form>
 <form>
    <button class="btn btn-primary" formaction="options/reset"> Сбросить настройки</button>
</form>
<br><br>
<form>
@endsection



