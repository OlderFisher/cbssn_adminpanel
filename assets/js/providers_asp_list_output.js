const callZipCode = function(){

    let zipcodeVal = $('#findZipCodeIdInput').val();
    if(zipcodeVal.length === 0) {
        zipcodeVal = '90221';
    }

    let outputDimension = [] ;
    const tableBody = document.getElementById("providersAspListTableBody");
    $(tableBody).empty();
    $.ajax({
        type: 'POST',
        data: { zipcode: zipcodeVal},
        url:  "assets/php/providers_asp_list.php",
        success: function (data) {
            const provider = JSON.parse(data),prov = provider.PROVIDER;

            if (provider.K2STATUS == 'FAILED') {
                $('.asp-not-response').html('ASP scenario not responsing. '+' Probably entered ZIP not valid') ;


            } else {
                $.each(prov, function (i, obj) {            // creating array of objects from json
                    const name = obj.NAME ;
                    obj.NAME = name.replace('%26','&') ;
                    outputDimension.push(obj) ;
                });

                $('#asp-zipcode-output').text(zipcodeVal) ;
                $('.asp-not-response').empty() ;

                outputDimension.map((point, i) => {                      // ASP scenario results list  to table

                    if(point.KEY != 'YOUTUBETV' && point.KEY != 'HULULIVETV'){ //Cleaning from Youtube tv and Hulu

                        const row = document.createElement("tr");
                        row.classList.add('trclass');
                        row.id = "idtr" + i + 1;

                        const cells =
                            "<td class='tdnum'>"+ (i + 1) + "</td>" +
                            "<td class='tdname'>" + point.NAME + "</td>" +
                            "<td class='tdkey'>" + point.KEY + "</td>" +
                            "<td class='tdchannel'>" + point.CHANNEL + "</td>" +
                            "<td class='tdbutton'><img class='image-copy' src='./assets/img/copy_link_plus.png' width='30px' height='30px' title='Copy row data to DB' /></td>";
                        row.innerHTML = cells;
                        tableBody.appendChild(row);

                    } ;
            });                                                   // table formatting finish

                $('.image-copy').each(function () {
                    $(this).bind('click', function () {

                        const trow = $(this).parents('.trclass') ;

                        $('#overlay').fadeIn(400,                   // call modal window to copy provider to DB  list
                            function(){
                                $('#modal_form')
                                    .css('display', 'flex')
                                    .animate({opacity: 1, top: '50%'}, 200);

                                const name = trow.children('.tdname').html() ;
                                currentKey = new Object() ;
                                currentKey.NAME = name ;
                                currentKey.KEY = trow.children('.tdkey').html() ;
                                currentKey.LINK = 'none' ;

                                operationType = 'COPY' ;

                                $('.modal-text').empty() ;
                                $('.operator_name').empty() ;

                                $('.modal-text').css('color','black')  ;
                                $('.modal-text').html('Do you really want to send to DB ?');
                                $('.operator_name').html(name);
                            });

                    }) ;
                }) ;
            }
        }
    });
} ;