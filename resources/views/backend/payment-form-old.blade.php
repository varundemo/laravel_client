@extends('layouts.backend') 



@section('content')

<main>
    <div class="row">
        <aside class="col-sm-6 offset-3">
            <article class="card">
                <div class="card-body p-5">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="nav-tab-card">
                            @foreach (['danger', 'success'] as $status)
                                @if(Session::has($status))
                                    <p class="alert alert-{{$status}}">{{ Session::get($status) }}</p>
                                @endif
                            @endforeach
                            <form role="form" method="POST" id="paymentForm" action="{{ url('/payment')}}">
                                @csrf

                                <div class="form-group">
                                    <label for="username">Amount</label>
                                    <input type="text" class="form-control" name="amount" placeholder="Amount (US Dollar)" >
                                </div>

                                <div class="form-group">
                                    <label for="username">Full name (on the card)</label>
                                    <input type="text" class="form-control" name="fullName" placeholder="Full Name">
                                </div>

                                <div class="form-group">
                                    <label for="cardNumber">Card number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="cardNumber" placeholder="Card Number">
                                        <div class="input-group-append">
                                            <span class="input-group-text text-muted">
                                            <i class="fab fa-cc-visa fa-lg pr-1"></i>
                                            <i class="fab fa-cc-amex fa-lg pr-1"></i>
                                            <i class="fab fa-cc-mastercard fa-lg"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label><span class="hidden-xs">Expiration</span> </label>
                                            <div class="input-group">
                                                <select class="form-control" name="month">
                                                    <option value="">MM</option>
                                                    @foreach(range(1, 12) as $month)
                                                        <option value="{{$month}}">{{$month}}</option>
                                                    @endforeach
                                                </select>
                                                <select class="form-control" name="year">
                                                    <option value="">YYYY</option>
                                                    @foreach(range(date('Y'), date('Y') + 10) as $year)
                                                        <option value="{{$year}}">{{$year}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label data-toggle="tooltip" title=""
                                                data-original-title="3 digits code on back side of the card">CVV <i
                                                class="fa fa-question-circle"></i></label>
                                            <input type="number" class="form-control" placeholder="CVV" name="cvv">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" >
                                    By adding your payment information, you agree to our <a href="{{ route('term-and-conditions') }}">terms and conditions </a>
                                </div>

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <button class="subscribe btn btn-primary btn-block mt-2" type="submit"> Confirm </button>

                                <div class="text-center">
                                    <a href="{{ route('payment-wallet') }}" class="btn btn-secondary mt-2">Back To Wallet</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
        </aside>
    </div>
</main>








@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#hard_freash").click(function(){
                console.log("you click this");
                location.reload(true);
                // location.reload();
            });

            $('input[name="amount"]').keypress(function(event) {
                var key = event.which;
                var keyChar = String.fromCharCode(key);
                var regex = /^[0-9]*$/;

                if (!regex.test(keyChar)) {
                event.preventDefault();
                return false;
                }
            });

            $('input[name="cardNumber"]').on('input', function() {
                var cardNumber = $(this).val().replace(/\D/g, '');

                if (cardNumber.length > 16) {
                cardNumber = cardNumber.substr(0, 16);
                }

                var formattedCardNumber = '';

                for (var i = 0; i < cardNumber.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedCardNumber += '-';
                }
                formattedCardNumber += cardNumber.charAt(i);
                }

                $(this).val(formattedCardNumber);
            });

        });

    

    </script>
@endsection
