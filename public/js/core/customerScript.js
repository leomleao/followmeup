// Testando a validação usando jQuery
$(function(){

    // 
    // Aciona a validação e formatação ao sair do input
// $('#customerCNPJ').blur(function(){

//     // O CPF ou CNPJ
//     var cpf_cnpj = $(this).val();
    
//     // Testa a validação e formata se estiver OK
//     if ( formata_cpf_cnpj( cpf_cnpj ) ) {
//         $(this).val( formata_cpf_cnpj( cpf_cnpj ) );
//         document.getElementById('cpfcnpjValidate').getElementsByTagName('small')[0].innerHTML = '';
//         document.getElementById('cpfcnpjValidate').setAttribute("class", "form-group");
//     } else {
//         document.getElementById('cpfcnpjValidate').getElementsByTagName('small')[0].innerHTML = 'CPF ou CNPJ inválido!';
//         document.getElementById('cpfcnpjValidate').setAttribute("class", "form-group has-error");
//     }
    
// });

$(".customertel").inputmask('(99)9999-9999',{
         greedy: false,
         rightAlign: false,
         showMaskOnHover: false,
         showMaskOnFocus: false,
         removeMaskOnSubmit:true,
         autoUnmask: true
     });

$(".customercel").inputmask('(99)9999[9]-9999',{
         greedy: false,
         rightAlign: false,
         showMaskOnHover: false,
         showMaskOnFocus: false,
         removeMaskOnSubmit:true,
         autoUnmask: true
     });

});


$(document).ready(function() {
    $('#search').hideseek();
});


(function init(){

var a = $.ajax({
        url:    'customer/populateContacts',
        type:   'POST',  
       }).done(loadCustomer);

function loadCustomer(e){

    json = JSON.parse(e);

// String.prototype.toProperCase = function () {
//     return this.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
// };

   for (var i = 0; i<2000; i++){ 
        contactBox = document.getElementById('contactBox0');

             Clone = contactBox.cloneNode(true);
        if (count==0) contactBox.parentNode.removeChild(contactBox); {
                  
                Clone.id = 'contactBox' + (i).toString();
                    if (i != 0) 
                contactBox.parentNode.appendChild(Clone);
            document.getElementById('contactBox' + (i).toString()).getElementsByClassName('circleInitials-name')[0].innerHTML = json[i].customercontactname.replace(/[^A-Z]/g, '');
            document.getElementById('contactBox' + (i).toString()).getElementsByTagName('a')[0].innerHTML = '&nbsp;' + json[i].customercontactname;
            document.getElementById('contactBox' + (i).toString()).getElementsByTagName('p')[1].innerHTML = '&nbsp;' + json[i].customername;
            document.getElementById('contactBox' + (i).toString()).getElementsByTagName('span')[4].innerHTML = '&nbsp;' + json[i].customertel;
            document.getElementById('contactBox' + (i).toString()).getElementsByTagName('p')[2].innerHTML = '&nbsp;' + json[i].customeremail;
            document.getElementById('contactBox' + (i).toString()).getElementsByTagName('p')[3].innerHTML = 
            '&nbsp;' + json[i].customerstreet + json[i].customerstreetnumber + ' - ' + json[i].customerstate;
              }

         }

            $('#demo').jplist({             
                itemsBox: '.list-results' 
                ,itemPath: '.hbox-xs' 
                ,panelPath: '.jplist-panel' 
            });
    }

})();

    document.getElementById('addNewCustomer').onclick = addNewCustomer;


    function addNewCustomer (e){
        $('#addCustomer').modal('toggle');
    } 

    function cleanZipForm() {
            //Limpa valores do formulário de cep.
            document.getElementById('customerStreet').value=("");
            document.getElementById('customerNeighborhood').value=("");
            document.getElementById('customerCity').value=("");
            document.getElementById('customerState').value=("");
            document.getElementById('customerIBGE').value=("");
    }

    function callback(content) {
        if (!("erro" in content)) {
            //Atualiza os campos com os valores.
            document.getElementById('customerStreet').value=(content.logradouro);
            document.getElementById('customerNeighborhood').value=(content.bairro);
            document.getElementById('customerCity').value=(content.localidade);
            document.getElementById('customerState').value=(content.uf);
            document.getElementById('customerIBGE').value=(content.ibge);
        } //end if.
        else {
            //CEP não Encontrado.
            cleanZipForm();
            alert("CEP não encontrado.");
        }
    }
        
    function searchZipCode(zip) {

        //Nova variável "cep" somente com dígitos.
        var cep = zip.replace(/\D/g, '');

        //Verifica se campo cep possui zip informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('customerStreet').value="...";
                document.getElementById('customerNeighborhood').value="...";
                document.getElementById('customerCity').value="...";
                document.getElementById('customerState').value="...";
                document.getElementById('customerIBGE').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
                cleanZipForm();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem zip, limpa formulário.
            cleanZipForm();
        }
    };

            // contactBox.innerHTML += '<div class="col-xs-12 col-lg-6 hbox-xs" id="contactBox' + (i).toString() + '">'
        //  +     '<div class="hbox-column width-2">'
        //  +       '<p class="circleInitials-name">' + json[i].customercontactname.replace(/[^A-Z]/g, '') + '</p>'
        //  +     '</div><!--end .hbox-column -->'
        //  +     '<div class="hbox-column v-top">'
        //  +       '<div class="clearfix">'
        //  +          '<div class="col-lg-12 margin-bottom-lg">'
        //  +           '<a class="text-lg text-medium cursive" href="" id="name"> &nbsp;' + json[i].customercontactname + '</a>'
        //  +         '</div>'
        //  +       '</div>'
        //  +       '<div class="clearfix opacity-75">'
        //  +          '<div class="col-md-12">'
        //  +            '<span class="md md-business"></span><p class="cursive" id="md-business"> &nbsp;' +json[i].customername+ '</p>'
        //  +          '</div>'
        //  +          '<div class="col-md-12">'
        //  +            '<span class="glyphicon glyphicon-envelope text-sm"></span><p class="cursive"></p>'
        //  +         '</div>'
        //  +       '</div>'
        //  +        '<div class="clearfix">'
        //  +          '<div class="col-lg-12">'
        //  +           '<span class="opacity-75">'
        //  +           '<span class="glyphicon glyphicon-map-marker text-sm"></span><p class="cursive"></p>' 
        //  +           '<span class="text-sm text-left block pull-right"></span>'
        //  +         '</div>'
        //  +       '</div>'
        //  +       '<div class="stick-top-right small-padding">'
        //  +         '<i class="fa fa-dot-circle-o fa-fw text-success" data-toggle="tooltip" data-placement="left" data-original-title="Cliente Novo"></i>'
        //  +       '</div>'
        //  +    '</div><!--end .hbox-column -->'
        //  +   '</div><!--end .hbox-xs -->';