<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/Style.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
        <title>PlayFunnel- Plan Subscription</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" /> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
        <style type="text/css">
            
            .credit-card-box .panel-title {
                 display: inline;
                 font-weight: bold;
            }
            .credit-card-box .form-control.error {
                 border-color: red;
                 outline: 0;
                 box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
            }
            .credit-card-box label.error {
                 font-weight: bold;
                 color: red;
                 padding: 2px 8px;
                 margin-top: 2px;
            }
            .credit-card-box .payment-errors {
                 font-weight: bold;
                 color: red;
                 padding: 2px 8px;
                 margin-top: 2px;
            }
            .credit-card-box label {
                display: block;
            }
            /* The old "center div vertically" hack */
            .credit-card-box .display-table {
                display: table;
            }
            .credit-card-box .display-tr {
                display: table-row;
            }
            .credit-card-box .display-td {
                 display: table-cell;
                 vertical-align: middle;
                 width: 60%;
            }
            /* Just looks nicer */
            .credit-card-box .panel-heading img {
                min-width: 180px;
            }
            
            #guardarHeader { display: none;}
        </style>
        
        
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>{{__('step2.title')}}</title> 
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">  
        <script src="https://kit.fontawesome.com/0190c3506a.js" crossorigin="anonymous"></script>
        
    </head>
    <body class="bg-white">
  	@include('nav_bar')
    <div class="container">
      
        <div class="d-flex align-items-center justify-content-center" style="margin-top: 100px;">
            <div >
                <h1> Plan Subscription: {{$plan->name}}</h1>
                <div class="panel panel-default credit-card-box">
                 
                    <div class="panel-heading d-flex justify-content-center" >
                        <div class="row display-tr" >
                            <h3 class="panel-title display-td" >Payment Details: {{$plan->price}}&euro; / {{$plan->interval}}</h3>
                            <div class="display-td" >                            
                                <img class="img-responsive pull-right" src="images/SVG/accepted_c22e0.png">
                            </div>
                        </div>
                                             
                    </div>
                    <div class="panel-body">
      
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                            <script>
                                setTimeout(redirectPage, 4000);
                        		function redirectPage(){
                        			window.location = 'account';
                        		}
                            </script>
                        @endif
      
                        <form 
                            role="form" 
                            action="{{ route('stripe.post') }}" 
                            method="post" 
                            class="require-validation"
                            data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                            id="payment-form">
                            @csrf
      						<input type='hidden' name='id' value='{{$plan->id}}' />
                            <div class='row'>
                                <div class='form-group col-xs-12'>
                                    <label class='control-label'>Name on Card</label> 
                                    <input class='form-control' size='4' type='text'>
                                </div>
                            </div>
      						
                            <div class='row'>
                                <div class='col-xs-12'>
                                    <div class="form-group">
                                    	<label class='control-label'>Card Number</label>
                                    	<div class="input-group">
                                    		<input autocomplete='off' class='form-control card-number' inputmode="numeric" size='20' type='text' placeholder='1234 1234 1234 1234'  id="cr_no"  name="cr_no">
                                    		<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    	</div>	
                                    </div>
                                </div>
                            </div>
      						
                            <div class='row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>CVC</label> 
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='123' size='4' type='text'>
                                    <div class="p-CardCvcIcons Input">
                                    	<p id="cvcDesc" class="u-visually-hidden hidden">3-digit code on back of card</p>
                                    	<div class="p-CardCvcIcons-group c-InputPadding">
                                    		<svg class="p-CardCvcIcons-svg" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="var(--colorIconCardCvc)" role="img" aria-labelledby="cvcDesc">
                                    			<path opacity=".2" fill-rule="evenodd" clip-rule="evenodd" d="M15.337 4A5.493 5.493 0 0013 8.5c0 1.33.472 2.55 1.257 3.5H4a1 1 0 00-1 1v1a1 1 0 001 1h16a1 1 0 001-1v-.6a5.526 5.526 0 002-1.737V18a2 2 0 01-2 2H3a2 2 0 01-2-2V6a2 2 0 012-2h12.337zm6.707.293c.239.202.46.424.662.663a2.01 2.01 0 00-.662-.663z"></path><path opacity=".4" fill-rule="evenodd" clip-rule="evenodd" d="M13.6 6a5.477 5.477 0 00-.578 3H1V6h12.6z"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M18.5 14a5.5 5.5 0 110-11 5.5 5.5 0 010 11zm-2.184-7.779h-.621l-1.516.77v.786l1.202-.628v3.63h.943V6.22h-.008zm1.807.629c.448 0 .762.251.762.613 0 .393-.37.668-.904.668h-.235v.668h.283c.565 0 .95.282.95.691 0 .393-.377.66-.911.66-.393 0-.786-.126-1.194-.37v.786c.44.189.88.291 1.312.291 1.029 0 1.736-.526 1.736-1.288 0-.535-.33-.967-.88-1.14.472-.157.778-.573.778-1.045 0-.738-.652-1.241-1.595-1.241a3.143 3.143 0 00-1.234.267v.77c.378-.212.763-.33 1.132-.33zm3.394 1.713c.574 0 .974.338.974.778 0 .463-.4.785-.974.785-.346 0-.707-.11-1.076-.337v.809c.385.173.778.26 1.163.26.204 0 .392-.032.573-.08a4.313 4.313 0 00.644-2.262l-.015-.33a1.807 1.807 0 00-.967-.252 3 3 0 00-.448.032V6.944h1.132a4.423 4.423 0 00-.362-.723h-1.587v2.475a3.9 3.9 0 01.943-.133z"></path>
                                    		</svg>
                                    	</div>
                                    </div>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Month</label> 
                                    <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>Expiration Year</label> 
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                </div>
                            </div>
      
                            <div class='row'>
                                <div class='col-md-12 error form-group hide'>
                                    <div class='alert-danger alert'>Please correct the errors and try again.</div>
                                </div>
                            </div>
      
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now</button>
                                </div>
                            </div>
                              
                        </form>
                        <!--  
                        <script async src="https://js.stripe.com/v3/pricing-table.js"></script>
						<stripe-pricing-table pricing-table-id="prctbl_1OKpEJFmHZlJ5Pcc8gOAjAb2" publishable-key="pk_test_51KlIAxFmHZlJ5PccZO8J9qZw3AEJlclDhnaE9bBPU6AqNQGp02dyj9EGaA7ndwo0HRy444u40ndo3W8OP1jeDlFK00vqKgtHvI"> </stripe-pricing-table>
                        -->
                    </div>
                </div>        
            </div>
        </div>
          
    </div>
      
    </body>
      
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      
    <script type="text/javascript">
    $(function() {


    	var cardNum = document.getElementById('cr_no');
    	cardNum.onkeyup = function (e) {
    	    if (this.value == this.lastValue) return;
    	    var caretPosition = this.selectionStart;
    	    var sanitizedValue = this.value.replace(/[^0-9]/gi, '');
    	    var parts = [];
    	    
    	    for (var i = 0, len = sanitizedValue.length; i < len; i += 4) {
    	        parts.push(sanitizedValue.substring(i, i + 4));
    	    }
    	    
    	    for (var i = caretPosition - 1; i >= 0; i--) {
    	        var c = this.value[i];
    	        if (c < '0' || c > '9') {
    	            caretPosition--;
    	        }
    	    }
    	    caretPosition += Math.floor(caretPosition / 4);
    	    
    	    this.value = this.lastValue = parts.join(' ');
    	    this.selectionStart = this.selectionEnd = caretPosition;
    	}

        
       
        var $form = $(".require-validation");
       
        $('form.require-validation').bind('submit', function(e) {
            var $form     = $(".require-validation"),
            inputSelector = ['input[type=email]', 'input[type=password]','input[type=text]', 'input[type=file]','textarea'].join(', '),
            $inputs       = $form.find('.required').find(inputSelector),
            $errorMessage = $form.find('div.error'),
            valid         = true;
            $errorMessage.addClass('hide');
      
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
              var $input = $(el);
              if ($input.val() === '') {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
              }
            });
       
            if (!$form.data('cc-on-file')) {
              e.preventDefault();
              Stripe.setPublishableKey($form.data('stripe-publishable-key'));
              Stripe.createToken({
                number: $('.card-number').val().replace(/\s/g,''),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
              }, stripeResponseHandler);
            }
      
      });
      
      function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('hide')
                    .find('.alert')
                    .text(response.error.message);
            } 
            else {
                /* token contains id, last4, and card type */
                var token = response['id'];
                console.log('El token:' + token )
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();

                
            }
        }
    });
    </script>
</html>