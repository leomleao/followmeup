window.onload = loading();

var myVar;

function loading() {
    myVar = setTimeout(showPage, 2100);

}

function showPage() {
  document.getElementById("logo").style.display = "none";
  document.getElementById("base").style.display = "block";

}

 $('#base').delay(1900).fadeIn(1000);

(function($){

				$(document).ready(function(){

					var $logo = $('#logo');

					/**
					 * Setup your Lazy Line element.
					 * see README file for more settings
					 */

		            $logo.lazylinepainter({
		                'svgData': svgData,
		                'strokeWidth': 3,
		                'strokeColor': '#3c763d',
                        'drawSequential': false,
                        'ease': 'easeInOutQuad'
		            });

                    setTimeout(function(){
                        $logo.lazylinepainter('paint');
                    }, 10)
				})

			})( jQuery );