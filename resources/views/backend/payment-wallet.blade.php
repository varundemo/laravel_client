@extends('layouts.backend') 

@section('content')
    <div class="row">
        <aside class="col-sm-6 offset-3">
            <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Payment Wallet</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Wallet Balance</h6>
                  <p class="card-text amount">$ {{ ( ( isset($balance) ) ? $balance : 0) }}</p>
                  <div class="text-center">
                    <a href="{{ route('payment') }}" class="btn btn-primary deposit-btn">Deposit Funds</a>
                    {{-- <a href="" class="btn btn-primary withdraw-btn">Withdraw Funds</a> --}}
                  </div>
                </div>
              </div>
              

        </aside>
    </div>


@endsection