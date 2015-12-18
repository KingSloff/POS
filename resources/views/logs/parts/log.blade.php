<div class="panel panel-primary">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">{{$log->title}}</h3>
        <div class="pull-right">{{$log->created_at->timezone(auth()->user()->timezone)}}</div>
    </div>
    <div class="panel-body">
        {{$log->description}}
    </div>
    @if(!empty($log->details))
    <hr>
    <div class="panel-body">
        <pre>{{$log->details}}</pre>
    </div>
    @endif
</div>