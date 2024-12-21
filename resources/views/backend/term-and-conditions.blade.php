@extends('layouts.backend') 

@section('content')

<div class="container py-4">
    <h2>Terms and Conditions</h2>

    <h4>Payment</h4>
    <p>
      By adding your payment information, you agree to let us automatically charge your card once your monthly budget is depleted.
      We do not provide refunds for any charges made to your card.
      We reserve the right to credit your account in the event of irrelevant leads, but we do not guarantee to do so.
      We are not liable for any leads you receive or any damages that may result from using our Service.
    </p>

    <h4>Intellectual Property</h4>
    <p>
      All intellectual property rights, including but not limited to trademarks, service marks, copyrights, patents, and trade secrets, are the property of "Contractors Universe".
      You may not use any intellectual property owned by "Contractors Universe" without our express written consent.
    </p>

    <h4>Liability</h4>
    <p>
      We are not liable for any damages arising from the use of our Service, including but not limited to direct, indirect, incidental, or consequential damages.
      We do not guarantee the accuracy, completeness, or timeliness of any information provided through our Service.
      We reserve the right to modify, suspend, or terminate our Service at any time without notice.
    </p>

    <h4>Indemnification</h4>
    <p>
      You agree to indemnify and hold harmless "Contractors Universe", its affiliates, officers, directors, employees, and agents from any and all claims, damages, liabilities, costs, and expenses, including reasonable attorneys' fees, arising from your use of our Service.
    </p>

    <h4>Governing Law</h4>
    <p>
      These terms and conditions are governed by and construed in accordance with the laws of the United States of America.
      Any dispute arising from or related to these terms and conditions will be resolved in the courts of California.
    </p>
  </div>

  <div class="text-center">
      <a href="{{ route('payment') }}" class="btn btn-secondary">Back To Payment</a>
  </div>
    
@endsection