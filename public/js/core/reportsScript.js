(function(namespace, $) {
	"use strict";

	var reportsScreen = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = reportsScreen.prototype;

	toastr.options = {
	  "positionClass": "toast-bottom-left",
	  "newestOnTop": true,
	  "onclick": null
	}
		

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		this._initDatePicker();
		this._initMultiSelect();
		this._initForm();
	};


	// =========================================================================
	// Date Picker
	// =========================================================================

	p._initDatePicker = function () {
		if (!$.isFunction($.fn.datepicker)) {
			return;
		}

		$('.date-picker').datepicker({
			autoclose: true, 
			todayHighlight: true,
			format: "dd/mm/yyyy",
			language: 'pt-BR'

		});
	    
	};

	// =========================================================================
	// Date Picker
	// =========================================================================

	p._initForm = function () {
		if (!$.isFunction($.fn._initForm)) {
			return;
		}

		$('form.report-filter').validate( {
		errorClass: "help-block",
		validClass: "ui-state-success",
		onkeyup:true,
		onfocusout:true,			
		ignore: ".ignore",
		rules: {
			endDate: {
				required: true
			},
			startDate: {
				required: true
			},
			salesPeople: {
				required: true
			}
			
		},
		showErrors: function (errorMap, errorList) {
	        this.defaultShowErrors();
	    },
		submitHandler: function(form) {
	        var data = $('form.report-filter').serialize();
	        event.preventDefault();
	        $.ajax({
	            url: "https://requestb.in/1fga3pj1",
	            type: 'POST',
	            datatype: 'json',
	            data: data,
	            success: function(response){
	            	if (response == 1){			            					            		            	
                	toastr.success('Cotação alterada com sucesso!');            
	            }
	            }
	        });  
	        return false;   
	    }
	});
	};




	// =========================================================================
	// MultiSelect
	// =========================================================================

	p._initMultiSelect = function () {
		if (!$.isFunction($.fn.multiSelect)) {
			return;
		}
		$('#salesPeople').multiSelect({selectableOptgroup: true});
	};



	// =========================================================================
	namespace.reportsScreen = new reportsScreen;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
