(function(namespace, $) {
	"use strict";

	var quotationScreen = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = quotationScreen.prototype;

	$('#quotationModalButton').on('click', toggleQuotationModal);
	
	$('#quotationReceivedConf').on('click', function(){
		$('#quotationReceivedConf').parent().toggleClass('toggleOpacity');
	});

	$('#quotationReceivedConfEdit').on('click', function(){
		$('#quotationReceivedConfEdit').parent().toggleClass('toggleOpacity');
	});

	function toggleQuotationModal (){
		$('#quotationModal').modal('toggle');
	}

	function toggleQuotationDelete (){
		$('#quotationDelete').modal('toggle');
	}

	function toggleQuotationEdit (){
		$('#quotationEditModal').modal('toggle');
	}			

	$(".valueMask").inputmask("decimal",{
         radixPoint:",", 
         groupSeparator: ".", 
         digits: 2,
         autoGroup: true,
         prefix: 'R$ ',
         rightAlign: false,
         showMaskOnHover: false,
 		 showMaskOnFocus: false,
 		 removeMaskOnSubmit:true,
 		 clearMaskOnLostFocus: true,
 		 autoUnmask: true
     });



	$(".quotationNumber").inputmask('999999[-999]',{
		 greedy: false,
		 rightAlign: false,
         showMaskOnHover: false,
 		 showMaskOnFocus: false,
 		 removeMaskOnSubmit:true,
 		 autoUnmask: true
     });



	toastr.options = {
	  "positionClass": "toast-bottom-left",
	  "newestOnTop": true,
	  "onclick": null
	}

	
		

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		this._initDataTables();
		this._initDatePicker();
		this._initAutoComplete();
	};

	// =========================================================================
	// Auto Complete
	// =========================================================================


	p._initAutoComplete = function () {
		if (!$.isFunction($.fn.easyAutocomplete)) {
			return;
		}

		$("#quotationCustomerID").easyAutocomplete({

		  url: function(phrase) {
		    return "quotation/dataRequest";
		  },

		 	

		  getValue: function(element) {
		    return element.customercode;
		  },

		  ajaxSettings: {
		    dataType: "json",
		    method: "POST",
		    data: {		    		
		      dataType: "customerTerminalNumber"
		    }
		  },

		  preparePostData: function(data) {
		    data.phrase = $("#quotationCustomerID").val();
		    return data;
		  },

		  requestDelay: 400,
		  cssClasses: "form-group floating-label",

		  
		  list: { 
				showAnimation: {
					type: "fade", //normal|slide|fade
					time: 400,
					callback: function() {}
				},

				hideAnimation: {
					type: "fade", //normal|slide|fade
					time: 200,
					callback: function() {}
				},
				match: {
					enabled: true,
					caseSensitive: true,
			        method: function(element, phrase ){
			        		var element = element.toString();
							if (element.search(phrase) > -1) {
								return true;
							} else {
								return false;
							}
						
			        }
				},
				sort: {
	              enabled: true
	            },
				
			}

		});
		//Adds label inside the easy-autocomplete div this allows material-admin to appear correctly
		$("#quotationCustomerID").after('<label for="quotationCustomerID">N. Cliente Terminal</label>')

		$("#quotationCustomerIDEdit").easyAutocomplete({

		  url: function(phrase) {
		    return "quotation/dataRequest";
		  },

		 	

		  getValue: function(element) {
		    return element.customercode;
		  },

		  ajaxSettings: {
		    dataType: "json",
		    method: "POST",
		    data: {		    		
		      dataType: "customerTerminalNumber"
		    }
		  },

		  preparePostData: function(data) {
		    data.phrase = $("#quotationCustomerID").val();
		    return data;
		  },

		  requestDelay: 400,
		  cssClasses: "form-group",

		  
		  list: { 
				showAnimation: {
					type: "fade", //normal|slide|fade
					time: 400,
					callback: function() {}
				},

				hideAnimation: {
					type: "fade", //normal|slide|fade
					time: 200,
					callback: function() {}
				},
				match: {
					enabled: true,
					caseSensitive: true,
			        method: function(element, phrase ){
			        		var element = element.toString();
							if (element.search(phrase) > -1) {
								return true;
							} else {
								return false;
							}
						
			        }
				},
				sort: {
	              enabled: true
	            },
				
			}

		});
		//Adds label inside the easy-autocomplete div this allows material-admin to appear correctly
		$("#quotationCustomerIDEdit").after('<label for="quotationCustomerID">N. Cliente Terminal</label>')



	}

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
	// DATATABLES
	// =========================================================================

	p._initDataTables = function() {
		if (!$.isFunction($.fn.dataTable)) {
			return;
		}

		// Init the demo DataTables
		this._createQuotationTable();
	};

	p._createQuotationTable = function() {
		$('form.quotationInsert').validate( {
				errorClass: "help-block",
				validClass: "ui-state-success",
				onkeyup:true,
				onfocusout:true,			
				ignore: ".ignore",
				rules: {
					quotationCustomerID: {
						required: true,
						remote: {
				        url: "quotation/dataRequest",
				        type: "post",
				        delay: 3
				      }
					},
					quotationCreationDate: {
						required: true
					},
					quotationNumber: {
						required: true
					},
					quotationValue: {
						required: true
					},
					quotationPriority: {
						required: true
					},
					quotationState: {
						required: true
					},
					quotationCommuWay: {
						required: true
					},
					quotationDealerUserID: {
						required: true
					}
					
				},
				showErrors: function (errorMap, errorList) {
			        this.defaultShowErrors();
			    },
				submitHandler: function(form) {
			        var data = $('form.quotationInsert').serialize();
			        event.preventDefault();
			        $.ajax({
			            url: "quotation/salvar",
			            type: 'POST',
			            datatype: 'json',
			            data: data,
			            success: function(data){
			            	toggleQuotationModal();				            		            	
			                table.ajax.reload();			               
		                	toastr.success('Cotação inserida com sucesso!');            
			                $('form.quotationInsert').trigger('reset');
			                
			                ($('#quotationReceivedConf').hasClass('toggleOpacity')) ? $('#quotationReceivedConf').removeClass('toggleOpacity'): '';
			            }
			        });  
			        return false;   
			    }
			});


		//Self-Explanatory, this function is used to format the footer Total Information
		function commaFormat(value)
			{
				var i = parseFloat(value);
				if(isNaN(i)) { i = 0.00; }
				var minus = '';
				if(i < 0) { minus = '-'; }
				i = Math.abs(i);
				i = parseInt((i + .005) * 100);
				i = i / 100;
				var s = new String(i);
				if(s.indexOf('.') < 0) { s += '.00'; }
				if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
				s = minus + s;
				var delimiter = ".";
				var a = s.split('.',2)
				var d = a[1];
				var i = parseInt(a[0]);
				if(isNaN(i)) { return ''; }
				var minus = '';
				if(i < 0) { minus = '-'; }
				i = Math.abs(i);
				var n = new String(i);
				var a = [];
				while(n.length > 3)
				{
					var nn = n.substr(n.length-3);
					a.unshift(nn);
					n = n.substr(0,n.length-3);
				}
				if(n.length > 0) { a.unshift(n); }
				n = a.join(delimiter);
				if(d.length < 1) { s = n; }
				else { s = n + ',' + d; }
				s = minus + s;
				return s;
			}	

		var table = $('#quotationTable').DataTable({
			"footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            var total = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            var  pageTotal = api
                .column( 2, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 2 ).footer() ).html(
                'R$'+ commaFormat(pageTotal) +' ( R$'+ commaFormat(total) +' total)'
            );

            // Total over all pages
            var total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            var  pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 3 ).footer() ).html(
                'R$'+ commaFormat(pageTotal) +' ( R$'+ commaFormat(total) +' total)'
            );

        },
			"dom": 'T<"clear">Blfrtip',
			"buttons": [
				'copy', 'excel', 'pdf'
			],
        	"ajax": "quotation/dataRequest",
        	"rowCallback": function( row, data, index ) {
        		
			     if ( data.isoverdue == true ) {
			    	row.className += ' overdue';
			     }
			  },
			"columns": [
				{
					"class": 'details-control',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{
					"data": "quotationnumber", render: function (data, type, row){
						return (!isNaN(data) && data > 999999 && data < 9999999)? data.toString().match(/^\d{6}/) + '-' + data.toString().match(/\d{1}$/): 
						(data > 9999999 && data < 99999999)? data.toString().match(/^\d{6}/) + '-' + data.toString().match(/\d{2}$/): 
						(data > 99999999)? data.toString().match(/^\d{6}/) + '-' + data.toString().match(/\d{3}$/): data;
					}
				},
				{
					"data": "quotationvalue", render: $.fn.dataTable.render.number( '.', ',', 2)
				},
				{
					"data": "quotationfinalvalue", render: $.fn.dataTable.render.number( '.', ',', 2) 
				},
				{	"data": "quotationstate" },
				{	
					"data": "quotationcreationdate",
					render: function ( data, type, row ) {
			          // If display or filter data is requested, format the date
			        
			          if (!data) return data;
			          if ( type === 'display' || type === 'filter' ) {			             			                      
			            return (moment(data).format("DD/MM/YYYY"));			                             
			          }
			          // Otherwise the data type requested (`type`) is type detection or
			          // sorting data, for which we want to use the raw date value, so just return
			          // that, unaltered
			          return data;
			          }
				},
				{
					"data": "quotationreceivedconf",
					"className": "dt-center",
				 	render: function ( data, type, row )
				 	{
				 		return (data)? '<i class="md md-done"></i>': '<i class="md md-assignment-late"></i>';
				    }
			    },
				{"data": "customername" },
				// {
				// 	"data": "customerstatus",
				// 	render: function ( data, type, row )
				//  	{
				//  		return (data == 1)? 'Novo': (data == 2)? 'Ativo' : (data == 3)? 'Inativo' : 'Bloqueado' ;
				//     }
				// },
				{"data": "dealername" },			
				{"data": "customercontactname" },			
				{
					"class": 'details-edit',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{
					"class": 'details-delete',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				}
			],

			// "tableTools": {
			// 	"sSwfPath": $('#quotationTable').data('swftools')
			// },

			"order": [[1, 'asc']],
			"language": {
				"lengthMenu": '_MENU_ cotações por página',
				"search": '<i class="fa fa-search"></i>',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				},
				"decimal": ",",
            	"thousands": ".",
	            "zeroRecords": "Nenhuma cotação encontrata :(  desculpe",
	            "info": "Mostrando página _PAGE_ de _PAGES_",
	            "infoEmpty": "Sem dados aqui :(",
	            "infoFiltered": "(filtrando de _MAX_ cotações)"
			}
		});
		var data 	 = {}
		,   dataEdit = {};

		//Add event listener for deleting each row
		$('#quotationTable tbody').on('click', 'td.details-delete', function() {	
			var tr = $(this).closest('tr');			
			data = {				
				row : table.row(tr)
			};
			$('#quotationDelete').modal('toggle');			
		});

		$('#quotationDelete').find('.btn-primary').on('click', function(){
			 	 	$('#quotationDelete').modal('toggle');
				    $.ajax({
				        url: "quotation/delete",
			            type: 'post',
						data : {
						    quotationid : data.row.data()['quotationid']
						},
				        success: function(response) {				        	
				        	if (response){
				            toastr.success('Excluido com sucesso');
				            data.row.remove();
				            table.draw();			            
				            }
				        }
				    });
			 });  

		//Add event listener for editing each row
		$('#quotationTable tbody').on('click', 'td.details-edit', function() {	
			var tr = $(this).closest('tr');			
			dataEdit = {				
				row : table.row(tr)
			};
			

			document.getElementById('quotationIDEdit').value = dataEdit.row.data().quotationid;
			$('#quotationNumberEdit').val(dataEdit.row.data().quotationnumber);
			document.getElementById('quotationCustomerIDEdit').value = dataEdit.row.data().customercode;
			document.getElementById('quotationValueEdit').value = dataEdit.row.data().quotationvalue;
			document.getElementById('quotationFinalValueEdit').value = dataEdit.row.data().quotationfinalvalue;

			var quotationprioritySelect = document.getElementById('quotationPriorityEdit');	
			for (var i = 0,lgt = quotationprioritySelect.options['length']; i < lgt ; i++){
				if (quotationprioritySelect.options[i].value == dataEdit.row.data().quotationpriority){
					quotationprioritySelect.selectedIndex = i;
				    break;
				}
			} 

			var quotationStateSelect = document.getElementById('quotationStateEdit');	
			for (var i = 0,lgt = quotationStateSelect.options['length']; i < lgt ; i++){
				if (quotationStateSelect.options[i].value == dataEdit.row.data().quotationstate){
					quotationStateSelect.selectedIndex = i;
				    break;
				}
			} 

			var quotationCommuWaySelect = document.getElementById('quotationCommuWayEdit');	
			for (var i = 0,lgt = quotationCommuWaySelect.options['length']; i < lgt ; i++){
				if (quotationCommuWaySelect.options[i].value == dataEdit.row.data().quotationcommuway){
					quotationCommuWaySelect.selectedIndex = i;
				    break;
				}
			} 

			var quotationDealeruserIDSelect = document.getElementById('quotationDealerUserIDEdit');	
			for (var i = 0,lgt = quotationDealeruserIDSelect.options['length']; i < lgt ; i++){
				if (quotationDealeruserIDSelect.options[i].value == dataEdit.row.data().quotationdealeruserid){
					quotationDealeruserIDSelect.selectedIndex = i;
				    break;
				}
			}
			if (dataEdit.row.data().quotationreceivedconf == 1) {
				$('#quotationReceivedConfEdit').attr('checked', true);
				$('#quotationReceivedConfEdit').parent().hasClass('toggleOpacity') ? $('#quotationReceivedConfEdit').parent().removeClass('toggleOpacity'): '';
			} else {				
				$('#quotationReceivedConfEdit').attr('checked', false);
				$('#quotationReceivedConfEdit').parent().hasClass('toggleOpacity') ? '': $('#quotationReceivedConfEdit').parent().removeClass('toggleOpacity');
			}
			document.getElementById('quotationCreationDateEdit').value = new Date(dataEdit.row.data().quotationcreationdate).toLocaleDateString();


			$('#quotationEditModal').modal('toggle');			
		});

		$('form.quotationEdit').validate( {
				errorClass: "help-block",
				validClass: "ui-state-success",
				onkeyup:true,
				onfocusout:true,			
				ignore: ".ignore",
				rules: {
					quotationCustomerID: {
						required: true,
						remote: {
				        url: "quotation/dataRequest",
				        type: "post",
				        delay: 3
				      }
					},
					quotationCreationDate: {
						required: true
					},
					quotationNumber: {
						required: true
					},
					quotationValue: {
						required: true
					},
					quotationPriority: {
						required: true
					},
					quotationState: {
						required: true
					},
					quotationCommuWay: {
						required: true
					},
					quotationDealerUserID: {
						required: true
					}
					
				},
				showErrors: function (errorMap, errorList) {
			        this.defaultShowErrors();
			    },
				submitHandler: function(form) {
			        var data = $('form.quotationEdit').serialize();
			        event.preventDefault();
			        $.ajax({
			            url: "quotation/editar",
			            type: 'POST',
			            datatype: 'json',
			            data: data,
			            success: function(response){
			            	toggleQuotationEdit();
			            	if (response == 1){			            					            		            	
			                table.ajax.reload();			               
		                	toastr.success('Cotação alterada com sucesso!');            
			                $('form.quotationEdit').trigger('reset');			                
			                ($('#quotationReceivedConfEdit').hasClass('toggleOpacity')) ? $('#quotationReceivedConfEdit').removeClass('toggleOpacity'): '';
			            }
			            }
			        });  
			        return false;   
			    }
			});
		
		//Add event listener for opening and closing details
		var o = this;
		
		
		$('#quotationTable tbody').on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table.row(tr);
			var isEditing = false;

			if (row.child.isShown()) {
				row.child.hide();
				tr.removeClass('shown inner-table');
				isEditing = false;
			}
			else { /* * * * * ELSE OPEN ROW START * * * * */ 				
				var rowdata = row.data();

				// Open this row
				row.child(o._formatDetails(row.data())).show();
				tr.addClass('shown inner-table');

				/* * * * * IF DESC 1 START * * * * */ 
				if (row.data()['followupdesc1'] != null){
					$('.followUpDesc')[0].onclick = followUpEdit1;
					$('#followUpDescEdit1')[0].onclick = followUpEdit1;

					function followUpEdit1 () {
					if (isEditing) return;	
					isEditing = true;		
					var div = $(this).closest('.col-md-4');
					div[0].innerHTML = '<form class="form followUpDescForm" id="followUpDescForm1" action="quotation/editFollowUp" method="post">'
								+			'<div class="card card-underline">'
								+				'<div class="card-head"><header>Editar Follow Up</header>'
								+					'<div class="tools">'
								+						'<div class="btn-group">'
								+						'<button type="submit" class="btn btn-icon-toggle btn-refresh"><i class="md md-save"></i></button>'
								+						'</div>'
								+					'</div>'
								+				'</div><!--end .card-head -->'
								+				'<div class="card-body" style="padding-top:5px">'
								+					'<!-- FOLLOW UP DESC 1 START -->'														
								+							'<div class="form-group" style="padding-top:7px">'
								+								'<textarea name="followUpDesc1" id="followUpDesc1" class="form-control" rows="3" >' + rowdata['followupdesc1'] + '</textarea>'
								+							'</div>'
								+ 						'<input type="hidden" value="1" name="which"></input>'
								+ 						'<input type="hidden" value="' + rowdata['quotationid'] + '" name="quotationID"></input>'						
								+					'<!-- FOLLOW UP DESC 1 END -->'
								+				'</div><!--end .card-body -->'
								+			'</div><!--end .card -->'
								+		'<form>';						
						$('#followUpDesc1').val = rowdata['followupdesc1'];
						$('.followUpDescForm').validate( {
									errorClass: "help-block",
									validClass: "ui-state-success",
									onkeyup:true,
									onfocusout:true,			
									ignore: ".ignore",
									rules: {
										followUpDesc1: {
											required: true
									    }					
									},
									showErrors: function (errorMap, errorList) {
								        this.defaultShowErrors();
								    },
									submitHandler: function(form) {
								        var data = $('.followUpDescForm').serialize();
								        event.preventDefault();
								        $.ajax({
								            url: "quotation/editFollowUp",
								            type: 'POST',
								            datatype: 'json',
								            data: data,
								            success: function(data){
								            	isEditing = false;			            		            	
								                table.ajax.reload();			               
							                	toastr.success('Alteração salva com sucesso!');								                
								            }
								        });  
								        return false;   
								    }
								});
								};


				} else if (row.data()['followupdesc1'] == null){
					$('.followUpDesc')[0].onclick = function  () {	
					if (isEditing) return;	
					isEditing = true;	
					var div = $(this).closest('.col-md-4');
					div[0].innerHTML = '<form class="form followupinsert" action="quotation/saveFollowUp" method="post">'
								+			'<div class="card card-underline">'
								+				'<div class="card-head"><header>Adicionar Follow Up</header>'
								+					'<div class="tools">'
								+						'<div class="btn-group">'
								+						'<button type="submit" class="btn btn-icon-toggle btn-refresh"><i class="md md-save"></i></button>'
								+						'</div>'
								+					'</div>'
								+				'</div><!--end .card-head -->'
								+				'<div class="card-body" style="padding-top:5px">'
								+					'<!-- FOLLOW UP DESC 1 START -->'														
								+							'<div class="form-group" style="padding-top:7px">'
								+								'<textarea name="followUpDesc1" id="followUpDesc1" class="form-control" rows="3"></textarea>'
								+							'</div>'
								+ 						'<input type="hidden" value="1" name="which"></input>'
								+ 						'<input type="hidden" value="' + rowdata['quotationid'] + '" name="quotationID"></input>'						
								+					'<!-- FOLLOW UP DESC 1 END -->'
								+				'</div><!--end .card-body -->'
								+			'</div><!--end .card -->'
								+		'<form>';
								};
								$('.followupinsert').validate( {
									errorClass: "help-block",
									validClass: "ui-state-success",
									onkeyup:true,
									onfocusout:true,			
									ignore: ".ignore",
									rules: {
										followUpDesc1: {
											required: true
									    }					
									},
									showErrors: function (errorMap, errorList) {
								        this.defaultShowErrors();
								    },
									submitHandler: function(form) {
								        var data = $('.followupinsert').serialize();
								        event.preventDefault();
								        $.ajax({
								            url: "quotation/saveFollowUp",
								            type: 'POST',
								            datatype: 'json',
								            data: data,
								            success: function(data){
								            	isEditing = false;				            		            	
								                table.ajax.reload();			               
							                	toastr.success('FollowUp inserido com sucesso!');								                
								            }
								        });  
								        return false;   
								    }
								});


				} /* * * * * IF DESC 1 END * * * * */ 

				/* * * * * IF DESC 2 START * * * * */ 

				if (rowdata['followupdesc2'] != null){
					$('.followUpDesc')[1].onclick = followUpEdit2;
					$('#followUpDescEdit2')[0].onclick = followUpEdit2;
					function followUpEdit2 () {						
					if (isEditing) return;		
					isEditing = true;			
					var div = $(this).closest('.col-md-4');
					div[0].innerHTML = '<form class="form followUpDescForm" id="followUpDescForm2" action="quotation/editFollowUp" method="post">'
								+			'<div class="card card-underline">'
								+				'<div class="card-head"><header>Editar Follow Up</header>'
								+					'<div class="tools">'
								+						'<div class="btn-group">'
								+						'<button type="submit" class="btn btn-icon-toggle btn-refresh"><i class="md md-save"></i></button>'
								+						'</div>'
								+					'</div>'
								+				'</div><!--end .card-head -->'
								+				'<div class="card-body" style="padding-top:5px">'
								+					'<!-- FOLLOW UP DESC 2 START -->'														
								+							'<div class="form-group" style="padding-top:7px">'
								+								'<textarea name="followUpDesc2" id="followUpDesc2" class="form-control" rows="3">'+ rowdata['followupdesc2']+'</textarea>'
								+							'</div>'
								+ 						'<input type="hidden" value="2" name="which"></input>'
								+ 						'<input type="hidden" value="' + rowdata['quotationid'] + '" name="quotationID"></input>'						
								+					'<!-- FOLLOW UP DESC 2 END -->'
								+				'</div><!--end .card-body -->'
								+			'</div><!--end .card -->'
								+		'<form>';
								$('#followUpDesc2').val = rowdata['followupdesc2'];
								$('.followUpDescForm').validate( {
									errorClass: "help-block",
									validClass: "ui-state-success",
									onkeyup:true,
									onfocusout:true,			
									ignore: ".ignore",
									rules: {
										followUpDesc1: {
											required: true
									    }					
									},
									showErrors: function (errorMap, errorList) {
								        this.defaultShowErrors();
								    },
									submitHandler: function(form) {
								        var data = $('.followUpDescForm').serialize();
								        event.preventDefault();
								        $.ajax({
								            url: "quotation/editFollowUp",
								            type: 'POST',
								            datatype: 'json',
								            data: data,
								            success: function(data){
								            	isEditing = false;			            		            	
								                table.ajax.reload();			               
							                	toastr.success('Alteração salva com sucesso!');								                
								            }
								        });  
								        return false;   
								    }
								});
								};


				} else if (rowdata['followupdesc2'] == null){
					$('.followUpDesc')[1].onclick = function  () {
					if (isEditing) return;	
					isEditing = true;		
					var div = $(this).closest('.col-md-4');
					div[0].innerHTML = '<form class="form" action="quotation/saveFollowUp" method="post">'
								+			'<div class="card card-underline">'
								+				'<div class="card-head"><header>Adicionar Follow Up</header>'
								+					'<div class="tools">'
								+						'<div class="btn-group">'
								+						'<button type="submit" class="btn btn-icon-toggle btn-refresh"><i class="md md-save"></i></button>'
								+						'</div>'
								+					'</div>'
								+				'</div><!--end .card-head -->'
								+				'<div class="card-body" style="padding-top:5px">'
								+					'<!-- FOLLOW UP DESC 2 START -->'														
								+							'<div class="form-group" style="padding-top:7px">'
								+								'<textarea name="followUpDesc2" id="followUpDesc2" class="form-control" rows="3" placeholder=""></textarea>'
								+							'</div>'
								+ 						'<input type="hidden" value="2" name="which"></input>'
								+ 						'<input type="hidden" value="' + rowdata['quotationid'] + '" name="quotationID"></input>'						
								+					'<!-- FOLLOW UP DESC 2 END -->'
								+				'</div><!--end .card-body -->'
								+			'</div><!--end .card -->'
								+		'<form>';
								};
								$('.followupinsert').validate( {
									errorClass: "help-block",
									validClass: "ui-state-success",
									onkeyup:true,
									onfocusout:true,			
									ignore: ".ignore",
									rules: {
										followUpDesc1: {
											required: true
									    }					
									},
									showErrors: function (errorMap, errorList) {
								        this.defaultShowErrors();
								    },
									submitHandler: function(form) {
								        var data = $('.followupinsert').serialize();
								        event.preventDefault();
								        $.ajax({
								            url: "quotation/saveFollowUp",
								            type: 'POST',
								            datatype: 'json',
								            data: data,
								            success: function(data){
								            	isEditing = false;				            		            	
								                table.ajax.reload();			               
							                	toastr.success('FollowUp inserido com sucesso!');								                
								            }
								        });  
								        return false;   
								    }
								});


				} /* * * * * IF DESC 2 END * * * * */ 

				/* * * * * IF DESC 3 START * * * * */ 


				if (rowdata['followupdesc3'] != null){
					$('.followUpDesc')[2].onclick = followUpEdit3;
					$('#followUpDescEdit3')[0].onclick = followUpEdit3;
					function followUpEdit3 () {
					if (isEditing) return;		
					isEditing = true;		
					var div = $(this).closest('.col-md-4');
					div[0].innerHTML = '<form class="form followUpDescForm" id="followUpDescForm3" action="quotation/editFollowUp" method="post">'
								+			'<div class="card card-underline">'
								+				'<div class="card-head"><header>Editar Follow Up</header>'
								+					'<div class="tools">'
								+						'<div class="btn-group">'
								+						'<button type="submit" class="btn btn-icon-toggle btn-refresh"><i class="md md-save"></i></button>'
								+						'</div>'
								+					'</div>'
								+				'</div><!--end .card-head -->'
								+				'<div class="card-body" style="padding-top:5px">'
								+					'<!-- FOLLOW UP DESC 3 START -->'														
								+							'<div class="form-group" style="padding-top:7px">'
								+								'<textarea name="followUpDesc3" id="followUpDesc3" class="form-control" rows="3">' + rowdata['followupdesc3'] + '</textarea>'
								+							'</div>'
								+ 						'<input type="hidden" value="3" name="which"></input>'
								+ 						'<input type="hidden" value="' + rowdata['quotationid'] + '" name="quotationID"></input>'						
								+					'<!-- FOLLOW UP DESC 3 END -->'
								+				'</div><!--end .card-body -->'
								+			'</div><!--end .card -->'
								+		'<form>';
								$('#followUpDesc3').val = rowdata['followupdesc3'];
								$('.followUpDescForm').validate( {
									errorClass: "help-block",
									validClass: "ui-state-success",
									onkeyup:true,
									onfocusout:true,			
									ignore: ".ignore",
									rules: {
										followUpDesc1: {
											required: true
									    }					
									},
									showErrors: function (errorMap, errorList) {
								        this.defaultShowErrors();
								    },
									submitHandler: function(form) {
								        var data = $('.followUpDescForm').serialize();
								        event.preventDefault();
								        $.ajax({
								            url: "quotation/editFollowUp",
								            type: 'POST',
								            datatype: 'json',
								            data: data,
								            success: function(data){
								            	isEditing = false;			            		            	
								                table.ajax.reload();			               
							                	toastr.success('Alteração salva com sucesso!');								                
								            }
								        });  
								        return false;   
								    }
								});
								};


				} else if (rowdata['followupdesc3'] == null){
					$('.followUpDesc')[2].onclick = function  () {
					if (isEditing) return;	
					isEditing = true;	
					var div = $(this).closest('.col-md-4');
					div[0].innerHTML = '<form class="form" action="quotation/saveFollowUp" method="post">'
								+			'<div class="card card-underline">'
								+				'<div class="card-head"><header>Adicionar Follow Up</header>'
								+					'<div class="tools">'
								+						'<div class="btn-group">'
								+						'<button type="submit" class="btn btn-icon-toggle btn-refresh"><i class="md md-save"></i></button>'
								+						'</div>'
								+					'</div>'
								+				'</div><!--end .card-head -->'
								+				'<div class="card-body" style="padding-top:5px">'
								+					'<!-- FOLLOW UP DESC 3 START -->'														
								+							'<div class="form-group" style="padding-top:7px">'
								+								'<textarea name="followUpDesc3" id="followUpDesc3" class="form-control" rows="3" placeholder=""></textarea>'
								+							'</div>'
								+ 						'<input type="hidden" value="3" name="which"</input>'
								+ 						'<input type="hidden" value="' + rowdata['quotationid'] + '" name="quotationID"</input>'						
								+					'<!-- FOLLOW UP DESC 3 END -->'
								+				'</div><!--end .card-body -->'
								+			'</div><!--end .card -->'
								+		'<form>';
								};
								$('.followupinsert').validate( {
									errorClass: "help-block",
									validClass: "ui-state-success",
									onkeyup:true,
									onfocusout:true,			
									ignore: ".ignore",
									rules: {
										followUpDesc1: {
											required: true
									    }					
									},
									showErrors: function (errorMap, errorList) {
								        this.defaultShowErrors();
								    },
									submitHandler: function(form) {
								        var data = $('.followupinsert').serialize();
								        event.preventDefault();
								        $.ajax({
								            url: "quotation/saveFollowUp",
								            type: 'POST',
								            datatype: 'json',
								            data: data,
								            success: function(data){
								            	isEditing = false;				            		            	
								                table.ajax.reload();			               
							                	toastr.success('FollowUp inserido com sucesso!');								                
								            }
								        });  
								        return false;   
								    }
								});


				} /* * * * * IF DESC 3 END * * * * */ 


			} /* * * * * ELSE OPEN ROW END * * * * */ 
			
		});/* * * * * CLOSE OF FUNCTION AND EVENT LISTENER * * * * */ 		 

	};/* * * * * CLOSE OF FUNCTION AND EVENT LISTENER p._createQuotationTable = function() { * * * * */ 		 

	// =========================================================================
	// DETAILS
	// =========================================================================

	p._formatDetails = function(d) {

		if(d.followupcreationdate1) var creationDate1 =  new Date(d.followupcreationdate1).toLocaleDateString();
		if(d.followupinsertiondate1) var insertionDate1 = new Date(d.followupinsertiondate1).toLocaleDateString();
		if(d.followupcreationdate2) var creationDate2 =  new Date(d.followupcreationdate2).toLocaleDateString();
		if(d.followupinsertiondate2) var insertionDate2 = new Date(d.followupinsertiondate2) .toLocaleDateString();
		if(d.followupcreationdate2) var creationDate3 =  new Date(d.followupcreationdate3).toLocaleDateString();
		if(d.followupinsertiondate3) var insertionDate3 = new Date(d.followupinsertiondate3).toLocaleDateString();

		

		// `d` is the original data object for the row
		var html = '<div class="row sub-table">'
		html +=					'<div class="col-md-12">'
		html +=							'<div class="card-body">'	
		html +=					'<div class="col-md-4">'
		html +=						'<div class="card card-underline">'
		html +=							'<div class="card-head">'
		html +=								'<header>Follow Up 1</header>'
		
			html +='<span>' + (insertionDate1 || ' ')  + '</span>'
		
		html +=								'<div class="tools">'
		html +=									'<div class="btn-group">'
		if (d.followupdesc1) {
			html +='<a class="btn btn-icon-toggle btn-refresh" id="followUpDescEdit1"><i class="md md-edit"></i></a>'
		}									
		html +=									'</div>'
		html +=								'</div>'
		html +=							'</div><!--end .card-head -->'
		html +=							'<div class="card-body">'
		if (d.followupdesc1) {
			html +='<p class="followUpDesc">'+d.followupdesc1+'</p>'
		} else {
			html +='<p class="followUpDesc">Clique para Inserir novo FollowUp</p>'
		}
		if (d.username1) {
			html +='<p class="float-right">'+ d.username1 +'</p>'
		} else {
			html +='<p class="float-right">&nbsp</p>'
		}
		html +=							'</div><!--end .card-body -->'
		html +=						'</div><!--end .card -->'
		html +=					'</div><!--end .col -->'



		html +=					'<div class="col-md-4 card-2">'
		html +=						'<div class="card card-underline">'
		html +=							'<div class="card-head">'
		html +=								'<header>Follow Up 2</header>'
		
			html +='<span>' + (insertionDate2 || ' ')  + '</span>'
		
		html +=								'<div class="tools">'
		html +=									'<div class="btn-group">'
		if (d.followupdesc2) {
			html +='<a class="btn btn-icon-toggle btn-refresh" id="followUpDescEdit2"><i class="md md-edit"></i></a>'
		}	
		html +=									'</div>'
		html +=								'</div>'
		html +=							'</div><!--end .card-head -->'
		html +=							'<div class="card-body">'
		if (d.followupdesc1 && d.followupdesc2) {
			html +='<p class="followUpDesc" >'+d.followupdesc2+'</p>'
		} else if (d.followupdesc1){
			html +='<p class="followUpDesc">Clique para Inserir novo FollowUp</p>'
		} else {
			html +='<p class="followUpDesc">Insira o primeiro followUp!</p>'
		}
		if (d.username2) {
			html +='<p class="float-right">'+ d.username2 +'</p>'
		} else {
			html +='<p class="float-right">&nbsp</p>'
		}
		html +=							'</div><!--end .card-body -->'
		html +=						'</div><!--end .card -->'
		html +=					'</div><!--end .col -->'
							
		html +=					'<div class="col-md-4 card-3">'
		html +=						'<div class="card card-underline">'
		html +=							'<div class="card-head">'
		html +=								'<header>Follow Up 3</header>'

			html +='<span>' + (insertionDate3 || ' ')  + '</span>'

		html +=								'<div class="tools">'
		html +=									'<div class="btn-group">'
		if (d.followupdesc3) {
			html +='<a class="btn btn-icon-toggle btn-refresh" id="followUpDescEdit3"><i class="md md-edit"></i></a>'
		}	
		html +=									'</div>'
		html +=								'</div>'
		html +=							'</div><!--end .card-head -->'
		html +=							'<div class="card-body">'
		if (d.followupdesc3 && d.followupdesc2 && d.followupdesc1) {
			html +='<p class="followUpDesc">'+d.followupdesc3+'</p>'
		} else if (d.followupdesc1 && d.followupdesc2) {
			html +='<p class="followUpDesc">Clique para Inserir novo FollowUp</p>'
		} else if (d.followupdesc1){
			html +='<p class="followUpDesc">Insira o segundo followUp!</p>'
		} else {
			html +='<p class="followUpDesc">Insira o primeiro followUp!</p>'
		} 
		if (d.username3) {
			html +='<p class="float-right">'+ d.username3 +'</p>'
		} else {
			html +='<p class="float-right">&nbsp</p>'
		}
		html +=							'</div><!--end .card-body -->'
		html +=						'</div><!--end .card -->'
		html +=					'</div><!--end .col -->'
										
		
		html +=							'</div><!--end .card-body -->'
		html +=					'</div><!--end .col -->'
		html +=				'</div><!--end .row -->'


		return html

						;

	};

	// =========================================================================
	namespace.quotationScreen = new quotationScreen;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
