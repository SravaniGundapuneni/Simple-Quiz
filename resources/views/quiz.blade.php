@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $quiz->name }}</div>


                <div class="panel-body">
                    @if(isset($questions))
                        <form class="" action="{{ url('quiz/result') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                            <ul class="list-group questions">
                                @foreach($questions as $key => $value)
                                    <li class="list-group-item">Question: <b>{{ $key }}</b>
                                         @foreach($value[0]->responses as $a => $q)
                                            
                                                <div class="radio">
                                                    <label><input type="radio" class="" name="option[{{$q->question_id}}]" value="{{ $q->id}}"> {{ $q->name}}</label>
                                                </div>
                                           
                                         @endforeach
                                       
                                    </li>
                                @endforeach
                                <div class="form-group final-submit text-center">
                                    
                                    <button type="submit" name="submit" class="btn btn-info">Submit and See Result!</button>
                                </div>
                            </ul>
                        </form>
                    @else
                    <h4 class="text-warning text-center">Please go back to select a <a href="{{ url('/') }}"> quiz </a></h4>
                    @endif
               
            </div>
        </div>
    </div>
</div>
@endsection
