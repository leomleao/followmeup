(function(namespace, $) {
	"use strict";

	var DemoTableDynamic = function() {
		// Create reference to this instance
		var o = this;
		// Initialize app when document is ready
		$(document).ready(function() {
			o.initialize();
		});

	};
	var p = DemoTableDynamic.prototype;

	document.getElementById('quotationModalButton').onclick = toggleQuotationModal;

	function toggleQuotationModal (e){
		$('#quotationModal').modal('toggle');
	} 

	// =========================================================================
	// INIT
	// =========================================================================

	p.initialize = function() {
		this._initDataTables();
		this._initDatePicker();
	};

	// =========================================================================
	// Date Picker
	// =========================================================================

	p._initDatePicker = function () {
		if (!$.isFunction($.fn.datepicker)) {
			return;
		}

		$('#demo-date').datepicker({autoclose: true, todayHighlight: true});
		$('#demo-date-month').datepicker({autoclose: true, todayHighlight: true, minViewMode: 1});
		$('#demo-date-format').datepicker({autoclose: true, todayHighlight: true, format: "dd/mm/yyyy"});
		$('#demo-date-range').datepicker({todayHighlight: true});
		$('#demo-date-inline').datepicker({todayHighlight: true});
		$('#demo-date2').datepicker({autoclose: true, todayHighlight: true});
		$('#demo-date-month2').datepicker({autoclose: true, todayHighlight: true, minViewMode: 1});
		$('#demo-date-format2').datepicker({autoclose: true, todayHighlight: true, format: "dd/mm/yyyy"});
		$('#demo-date-range2').datepicker({todayHighlight: true});
		$('#demo-date-inline2').datepicker({todayHighlight: true});
	};


	// =========================================================================
	// DATATABLES
	// =========================================================================

	p._initDataTables = function() {
		if (!$.isFunction($.fn.dataTable)) {
			return;
		}

		// Init the demo DataTables
		this._createDataTable2();
	};

	p._createDataTable2 = function() {
		var table = $('#datatable2').DataTable({
			"dom": 'T<"clear">lfrtip',
			"data": json,
			"columns": [
				{
					"class": 'details-control',
					"orderable": false,
					"data": null,
					"defaultContent": ''
				},
				{"data": "quotationnumber" },
				{"data": "quotationvalue" },
				{"data": "quotationfinalvalue" },
				{"data": "quotationstate" },
				{"data": "quotationsenddate" },
				{"data": "customername" },
				{"data": "customerstatus" },
				{"data": "customercontact" },
				{"data": "quotationcommuway" },
				{"data": "quotationreceivedconf" }
			],
			"tableTools": {
				"sSwfPath": $('#datatable2').data('swftools')
			},
			"order": [[1, 'asc']],
			"language": {
				"lengthMenu": '_MENU_ entries per page',
				"search": '<i class="fa fa-search"></i>',
				"paginate": {
					"previous": '<i class="fa fa-angle-left"></i>',
					"next": '<i class="fa fa-angle-right"></i>'
				}
			}
		});
		
		//Add event listener for opening and closing details
		var o = this;
		$('#datatable2 tbody').on('click', 'td.details-control', function() {
			var tr = $(this).closest('tr');
			var row = table.row(tr);

			if (row.child.isShown()) {
				// This row is already open - close it
				row.child.hide();
				tr.removeClass('shown');
			}
			else {
				// Open this row
				row.child(o._formatDetails(row.data())).show();
				tr.addClass('shown');
			}
		});
	};

	// =========================================================================
	// DETAILS
	// =========================================================================

	p._formatDetails = function(d) {
		// `d` is the original data object for the row
		return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
				'<tr>' +
				'<td>Full name:</td>' +
				'<td>' + d.quotationnumber + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Extension number:</td>' +
				'<td>' + d.quotationnumber + '</td>' +
				'</tr>' +
				'<tr>' +
				'<td>Extra info:</td>' +
				'<td>And any further details here (images etc)...</td>' +
				'</tr>' +
				'</table>';
	};

	// =========================================================================
	namespace.DemoTableDynamic = new DemoTableDynamic;
}(this.materialadmin, jQuery)); // pass in (namespace, jQuery):
