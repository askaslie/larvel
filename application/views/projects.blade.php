@layout('elements.main')
@section('content')

<form id="project-select">
    <?
//        print_r( $subrubrics );
//        die();
    ?>
    <select name="project_id" onchange="document.forms['project-select'].submit()">
        @foreach( $projects as $project )
        <option {{$project->external_id == $current_project_id ? 'selected': ' ' }} value="{{ $project->external_id }}">{{ $project->name }}</option>
        @endforeach
    </select>
</form>
<form method="post">
    <input class="btn btn-primary" type="submit" value="Сохранить">
    <div class="row">
<!--        <div class="span4">-->
            <? $i = 0; ?>
            @foreach( $rubrics as $rubric_id => $title )
                @if($i == 0)
                    <div class="span4">
                @endif
                <h4> {{ $title }}</h4>
                @foreach( $subrubrics[$rubric_id] as $subrubric )
                    <label class="checkbox "><input name="arr[]" type="checkbox" {{ !$subrubric['status']? '':'checked'}}
                        value="{{ $subrubric['external_id'] }}">{{ $subrubric['name'] }}<a href="/task?taskId={{ $subrubric['task_id'] }}">{{ $subrubric['status'] }}</a></abbr></a></label>
                @endforeach
                @if ($i++ > 2 )
                        </div>
                        <? $i = 0; ?>
                @endif
            @endforeach
        </div>
    </div>
         <input class="btn btn-primary" type="submit" value="Сохранить">
</form>
<br><br>
<form>
@endsection



