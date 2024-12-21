
<!-- ---------------------------------------------------------------------------- -->
<!-- NOTE: Feel free to ask or have your webmaster change the styling of the form  -->
<!-- ---------------------------------------------------------------------------- -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
    <script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.pack.js"></script> 
    <script>
        function textCounter( field, spanId, maxlimit ) {
          if ( field.value.length > maxlimit )
          {
            field.value = field.value.substring( 0, maxlimit );
            alert( 'Textarea value can only be ' + maxlimit + ' characters in length.' );
            return false;
          }
          else
          {
            jQuery('#'+spanId).text('' + (maxlimit - field.value.length) + ' characters remaining');
          }
        }

        jQuery(document).ready(function(){
            jQuery.validator.addMethod(
                "phoneUS", function(phone_number, element) {
                    phone_number = phone_number.replace(/\s+/g, ""); 
	                return this.optional(element) || phone_number.length > 9 &&
		                phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
                }, 
                "Please specify a valid phone number"
            );

            jQuery('#SubmitButton').click(function(evt) {
              var isValid = jQuery('form').valid();

              <!--if (!isValid)-->
              evt.preventDefault();
              
              if (isValid)
                {
                    jQuery("div.error").hide();
            
                    /*jQuery("body").append('<form id="form-to-submit" style="visibility:hidden;"></form>');
                    jQuery("#form-to-submit").html(jQuery("#marketsharpmFieldSet").clone());*/
                    
                    var textareaData = new Array();
                    jQuery.each(jQuery("#marketsharpmFieldSetDiv textarea"), function(index, value) {
                        var cleanValue = escape(jQuery.trim(value.value));

                        if (cleanValue !== '')
                            textareaData[value.name] = cleanValue;			
                    });

                    var selectData = new Array();
                    jQuery.each(jQuery("#marketsharpmFieldSetDiv select"), function(index, value) {
                        var cleanValue = escape(jQuery.trim(value.value));

                        if (cleanValue !== '')
                            selectData[value.name] = cleanValue;			
                    });

                    /*var values = jQuery("#form-to-submit").serialize();*/
                    var values = jQuery("#marketsharpmForm").serialize();

                    if (values == '')
                    {
                        jQuery("body").append('<form id="form-to-submit" style="visibility:hidden;"></form>');
                        jQuery("#form-to-submit").html(jQuery("#marketsharpmFieldSet").clone());
                        
                        values = jQuery("#form-to-submit").serialize();
                    }

                    /*Perform manual check for Phone or Email (at least one is required)*/
                    var email = jQuery("#form-to-submit #MSM_email").val();
                    var homePhone = jQuery("#form-to-submit #MSM_homephone").val();
                    var cellPhone = jQuery("#form-to-submit #MSM_cellphone").val();
                    var workPhone = jQuery("#form-to-submit #MSM_workphone").val();

                    if(email === '' && homePhone === '' && cellPhone === '' && workPhone === '')
                    {
                        jQuery("div.error span").html("Phone or Email is required.");
                        jQuery("div.error").show();
                        return false; //short-circuit
                    }

                    for(var keyName in selectData) {
                        var regEx = new RegExp("&" + keyName + "=[^&]*", "gi");
                        var allSelectData = regEx.exec(values);
	                    values = values.replace(allSelectData, "&" + keyName + "=" + selectData[keyName]);
                    }
                    for(var keyName in textareaData) {
                        var regEx = new RegExp("&" + keyName + "=[^&]*", "gi");
                        var allInterestData = regEx.exec(values);

	                    values = values.replace(allInterestData, "&" + keyName + "=" + textareaData[keyName]);
                    }

                    values = values.replace(/&/g, "&|&");           
                    //console.log('values: ', JSON.stringify(values)); 

                    /*jQuery("#form-to-submit").remove();*/

                     jQuery.getJSON("https://haaws.marketsharpm.com/LeadCapture/MarketSharp/LeadCapture.ashx?callback=?",  
                       { "info": values, "version" : 2 },
                       function(data, msg) {  
                        jQuery("div.error span").html("");
                        if (data.errors.length > 0)
                        {
                            jQuery.each(data.errors, function() {
                                jQuery("div.error span").append(this + "<br />");
                            });
                            jQuery("div.error span br:last").remove();
                            jQuery("div.error").show();
                        }                        
                        else if (data.redirectUrl != '')
                        {
                            window.location.replace(data.redirectUrl);
                        }
                        else if (data.msg == 'success')
                        {
                         jQuery('#marketsharpmFieldSetDiv').html("<div id='message' style='text-align: center;'></div>");  
                         jQuery('#message').html("<h2>Contact Information Submitted!</h2>")  
                         .append("<p>We will be in touch soon.</p>")  
                         .hide()  
                         .fadeIn(1500, function() {  
                           jQuery('#message').append("");  
                         });  
                        }
                        else
                        {
                        jQuery("div.error span").html("There was an unknown error submitting the form.");
                        jQuery("div.error").show();
                        }
                       }  
                     );
                     return false;            
                }
            });
    
            jQuery("form").validate({
                onsubmit: false,
                invalidHandler: function(e, validator) {
                    var errors = validator.numberOfInvalids();
                    if (errors) {
                        var message = errors == 1
                        ? 'You missed 1 field. It has been highlighted below'
                        : 'You missed ' + errors + ' fields. They have been highlighted below';
                        jQuery("div.error span").html(message);
                        jQuery("div.error").show();
                    } else {
                        jQuery("div.error").hide();
                    }
                },
                onkeyup: false
             });
          });
    </script>

<style type="text/css">
/*
#marketsharpmFormDiv2 {
    width: 525px;
}
#marketsharpmFieldSetDiv {
    margin: 10px;
}
#marketsharpmFormDiv2 label {
    width: 9em;
    float: left;
    text-align: right;
    margin-right: 0.5em;
    display: block
}
#marketsharpmFormDiv2 input {
    border-spacing: 0px;
    margin: 0px;
    padding: 0px;
    space: 0px;
}
*/
#marketsharpmFormDiv2 .submit {
    text-align: center;
    margin-left: 0em;
}
#marketsharpmFormDiv2 label.error {
    color: red;
    float: none;
    display: inline;
    margin-left: 0.5em;
}
#marketsharpmFormDiv2 p input.error {
    background-color: #FFFFD5;
    border-bottom-color: red;
    border-bottom-style: solid;
    border-bottom-width: 2px;
    border-left-color-ltr-source: physical;
    border-left-color-rtl-source: physical;
    border-left-color-value: red;
    border-left-style-ltr-source: physical;
    border-left-style-rtl-source: physical;
    border-left-style-value: solid;
    border-left-width-ltr-source: physical;
    border-left-width-rtl-source: physical;
    border-left-width-value: 2px;
    border-right-color-ltr-source: physical;
    border-right-color-rtl-source: physical;
    border-right-color-value: red;
    border-right-style-ltr-source: physical;
    border-right-style-rtl-source: physical;
    border-right-style-value: solid;
    border-right-width-ltr-source: physical;
    border-right-width-rtl-source: physical;
    border-right-width-value: 2px;
    border-top-color: red;
    border-top-style: solid;
    border-top-width: 2px;
	border-right-color: red;
    border-right-style: solid;
    border-right-width: 2px;
	border-left-color: red;
    border-left-style: solid;
    border-left-width: 2px;
    color: red;
    margin-bottom: 0;
    margin-left: 0;
    margin-right: 0;
    margin-top: 0;
}
#marketsharpmFormDiv2 div.error {
    text-align: center;
    color: red;
}
#marketsharpmFormDiv2 .hidden {
    display: none;
}
</style>

<div class="modal fade" id="marketsharp_contractor2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AI Construction Solutions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <p>Please check below lead information before sending to the markesharp contractor</p>
<div id="marketsharpmFormDiv2">     
    <form id="marketsharpmForm" method="post" action="https://haaws.marketsharpm.com/LeadCapture/MarketSharp/LeadCapture.ashx">
    <fieldset id="marketsharpmFieldSet" >
    <div id="marketsharpmFieldSetDiv">  
        <div class="error" style="display:none;">
        <span></span><br clear="all" />
        </div> 
        <!-- ------------------------------------------------------ -->
        <!-- NOTE: Minimally First Name and Last Name are required. -->
        <!-- ------------------------------------------------------ -->
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_firstname">First Name:</label>
					<input id="MSM_firstname" type="text" name="MSM_firstname" class="required form-control" maxlength="50" value="{{ $first_name  }}" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_lastname">Last Name:</label>
					<input id="MSM_lastname" type="text" name="MSM_lastname" class="required form-control" maxlength="50" value="{{ $last_name }}"  />
				</div>
			</div>
		</div>
        
        <!-- --------------------------------------------------------------------- -->
        <!-- NOTE: You may remove any lines below that you do not wish to collect. -->
        <!-- --------------------------------------------------------------------- -->
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_address1">Address Line 1:</label>
					<input id="MSM_address1" type="text" name="MSM_address1" maxlength="200" class="form-control" value="{{ $Lead->address ?? 'N/A'  }}" />
				</div>
			</div>
			<div class="col-sm-6">	
				<div class="form-group">
					<label for="MSM_address2">Address Line 2:</label>
					<input id="MSM_address2" type="text" name="MSM_address2" maxlength="100" class="form-control" />
				</div>
			</div>
		</div>
				
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_city">City:</label>
					<input id="MSM_city" type="text" name="MSM_city" maxlength="50" class="form-control" value="{{ $Lead->city ?? 'N/A'  }}" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_state">State:</label>
					<input id="MSM_state" type="text" name="MSM_state" maxlength="50" class="form-control" value="{{ $Lead->state ?? 'N/A'  }}" />
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_zip">Zip:</label>
					<input id="MSM_zip" type="text" name="MSM_zip" maxlength="50" class="form-control" value="{{ $Lead->zip ?? 'N/A'  }}" />
				</div>
			</div>
        
        <!-- ----------------------------------------------------- -->
        <!-- NOTE: Phone number or Email is required. -->
        <!-- ----------------------------------------------------- -->
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_email">Email:</label>
					<input id="MSM_email" type="text" name="MSM_email" class=" email form-control" maxlength="100" value="{{ $Lead->email ?? 'N/A'  }}" />
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_homephone">Home Phone:</label>
					<input id="MSM_homephone" type="text" name="MSM_homephone" class=" phoneUS form-control" maxlength="15" />
				</div>
			</div>	
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_cellphone">Cell Phone:</label>
					<input id="MSM_cellphone" type="text" name="MSM_cellphone" class="phoneUS form-control" maxlength="15" value="{{ $Lead->phone ?? 'N/A'  }}" />
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_workphone">Work Phone:</label>
					<input id="MSM_workphone" type="text" name="MSM_workphone" class="phoneUS form-control" maxlength="15" />
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label for="MSM_custom_Best_Time_To_Reach">Best Time to Reach:</label>
					<input id="MSM_custom_Best_Time_To_Reach" type="text" name="MSM_custom_Best_Time_To_Reach" maxlength="75" class="form-control" />
				</div> 
			</div>
		</div>
		
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<label for="MSM_custom_Interests">Interest In:</label>
					<textarea rows="3" cols="30" id="MSM_custom_Interests" name="MSM_custom_Interests" class="form-control" />{{ $Lead->category  ?? '' }}</textarea>
				</div>
			</div>
		</div>
		
		     
        <!-- ----------------------------------------------------- -->
        <!-- NOTE: The following hidden fields below are required. -->
        <!-- ----------------------------------------------------- -->       
        <p class="submit"><input type="submit" id="SubmitButton" name="submitbutton" value="Submit Info" class="submit btn btn-primary submit-btn" /></p>
        <input type="hidden" name="MSM_source" value="af6e96a7-7086-4467-bec0-af3c39b46c10" />	
        <input type="hidden" name="MSM_coy" value="4691" />
        <input type="hidden" name="MSM_formId" value="af6e96a7-7086-4467-bec0-af3c39b46c10" />
        <input type="hidden" name="MSM_leadCaptureName" value="MarketSharp" />
        
    </div>
    </fieldset>
    </form>
</div>



		</div>      
    </div>
  </div>
</div>