@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Your result </div>
                <div class="panel-body">
                    <ul class="list-group text-center">
                          @if(isset($message))
                          <li class="list-group-item text-warning">{{$message}}</li>
                          @endif
                          @if(isset($correct_answer))
                          <li class="list-group-item">Correct Answer: <span class="text-success">{{ count($correct_answer) }}</span></li>
                          @endif
                          @if(isset($wrong_answer))
                          <li class="list-group-item">Wrong Answer: <span class="text-danger">{{ count($wrong_answer) }}</span></li>
                          @endif
                          @if(isset($percentage))
                          <li class="list-group-item">Success Percentage: <span class="text-info">{{$percentage}}%</span></li>
                          @endif
                    </ul>
                    
                <h4 class="text-center">Please go back to select a <a href="{{ url('/home') }}"> quiz </a></h4>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
