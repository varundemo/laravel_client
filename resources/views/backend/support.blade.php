@extends('layouts.backend') 

@section('content')

<div class="row">
    <div class="col-sm-8 ml-5">
        <form action="{{ route('support') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Example textarea</label>
                <textarea class="form-control" name="ticket_msg" id="exampleFormControlTextarea1" rows="5"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-warning text-white">Raise Ticket</button>
            </div>
        </form>
    </div>
    
    
</div>
    
@endsection