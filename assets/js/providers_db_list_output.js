/**
 * Created by Lilik Aleksandr on 14.06.17.
 */

const callDBList = function(){


    let outputDimension = [] ;

    const tableBody = document.getElementById("providersDBListTableBody");

    $(tableBody).empty();


    $.ajax({
        type: 'POST',
        url:  "assets/php/get_db_list.php",
        success: function (data) {
            const provider = JSON.parse(data);

            if (provider.length == 0 ) {
                $('.db-not-response').html('Data Base not responsing. '+' Probably DB file is  empty') ;


            } else {
                $.each(provider, function (i, obj) {            // creating array of objects from json
                    const name = obj.name ;

                    obj.name = name.replace('%26','&') ;
                    outputDimension.push(obj) ;

                });


                $('.db-not-response').empty() ;

                outputDimension.map((point, i) => {                      // ASP scenario results list  to table
                    const row = document.createElement("tr");
                    row.classList.add('trDBclass');
                    row.id = "idDBtr" + i + 1;

                    var tdurlstring = '';

                    if(point.link == 'none'){
                        tdurlstring =  "<td class='tdurl'>"+ point.link +"</td>" ; // none link is output without <a> tag
                    }else {
                        tdurlstring =  "<td class='tdurl'><a id = 'outlink'" + "href='" + point.link + "'target='_blank'>"+ point.link +"</a></td>" ;
                    } ;

                    const cells =
                        "<td class='tdnum'>"+ (i + 1) + "</td>"      +
                        "<td class='tdname'>" + point.name + "</td>" +
                        "<td class='tdkey'>" + point.key + "</td>"   +
                             tdurlstring +
                        "<td class='tdbutton'><img class='image-edit' src='./assets/img/file_edit.png' width='30px' height='30px' title='Edit URL'></td>" +
                        "<td class='tdbutton'><img class='image-delete' src='./assets/img/file_delete.png' width='30px' height='30px' title='Delete row'></td>";

                    row.innerHTML = cells;
                    tableBody.appendChild(row);

                    if(point.link == 'none'){  // none link is output in red color
                        var rowId ='#'+row.id ;
                        $(rowId).css('color','red') ;
                    } ;

                });                                                   // table formatting finish


                $('.image-edit').each(function () {                   // call row editor

                    $(this).bind('click', function () {
                        const trow = $(this).parents('.trDBclass') ;
                        $('#overlay').fadeIn(400,                   // call modal window to edit provider from list
                            function(){
                                $('#modal_form').css('display', 'flex').animate({opacity: 1, top: '50%'}, 200);

                                var name = trow.children('.tdname').html() ;
                                var href = trow.children('.tdurl').html() ;
                                var url = $(href).attr('href') ;
                                if(typeof(url) == "undefined"){ url = '';} ;

                                currentKey = [] ;
                                currentKey['NAME'] = name ;
                                currentKey['KEY'] = trow.children('.tdkey').html() ;

                                operationType = 'EDIT' ;

                                $('.modal-text').empty() ;
                                $('.operator_name').empty() ;
                                $('.modal-text').html('Edit URL mode for ');
                                $('.operator_name').html(name);

                                var valueUrl = document.getElementById('urledit') ;
                                valueUrl.value = url;
                                $('#urledit').css('visibility','visible') ;

                            });
                    }) ;
                }) ;


                $('.image-delete').each(function () {               // call row delete

                    $(this).bind('click', function () {
                        const trow = $(this).parents('.trDBclass') ;
                        $('#overlay').fadeIn(400,                   // call modal window to delete provider from list
                            function(){
                                $('#modal_form').css('display', 'flex').animate({opacity: 1, top: '50%'}, 200);

                                var name = trow.children('.tdname').html() ;

                                currentKey = [] ;
                                currentKey['NAME'] = name ;
                                currentKey['KEY'] = trow.children('.tdkey').html() ;

                                operationType = 'DELETE' ;

                                $('.modal-text').empty() ;
                                $('.operator_name').empty() ;


                                $('.modal-text').html('Do you really want to delete ?');
                                $('.operator_name').html(name);

                            });

                    }) ;
                }) ;
            }
        }
    });
} ;

