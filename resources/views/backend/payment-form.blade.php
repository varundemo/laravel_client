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
                                <div class="form-group">
                                    <label for="username">Amount</label>
                                    <input type="text" class="form-control" name="amount" placeholder="Amount (US Dollar)" >
                                </div>

                                <div class="form-group">
                                    <label for="username">Full name (on the card)</label>
                                    <input type="text" class="form-control" name="fullName" placeholder="Full Name">
                                </div>

                                <label for="card-element">Credit or debit card</label>
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <div class="form-check mt-4">
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
                            
                                <div class="mt-2">
                                    <button class="subscribe btn btn-primary btn-block mt-2" type="submit"> Confirm </button>
                                </div>
                               
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
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
<script src="https://js.stripe.com/v3/"></script>

<script>
    var stripe = Stripe('pk_test_51NBVkiCxg0aufXuiDhfunJz6qfw5zQ0onG4jkroUrduCzY2egrmm1IOMPsIEJX0dO234SEuI34jLjxOCD0xcUnMF00ejc6M7wB'); // Use your publishable key here
    var elements = stripe.elements();

    var card = elements.create('card', {
        hidePostalCode: true, // This will hide the ZIP code field
        });
    card.mount('#card-element');

    var form = document.getElementById('paymentForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        stripe.createToken(card).then(function (result) {
            if (result.error) {
                // Inform the user if there are errors.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Tokenize the card information and submit the form.
                stripeTokenHandler(result.token);
            }
        });
    });

    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to your server
        var form = document.getElementById('paymentForm');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>

@endsection
