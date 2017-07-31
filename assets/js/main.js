/**
 * Created by Lilik Aleksandr on 13.06.17.
 */

var currentKey     = [] ;
var operationType = ''  ;
var dbKey, dbName, dbLink     ;


const getInput = function (){
    const input = document.getElementById('urledit').value ;

    return input ;
} ;

$(document).ready(() => {

    $('#zipSubmitBtn').on('click', callZipCode) ;

    $('.image-copy').trigger('click');
    $('.image-edit').trigger('click');
    $('.image-delete').trigger('click');

    $('#urledit').on('onblur',getInput()) ;


    /*-------- modal window playing --------------------------------------------*/
    $('#modal_close, #overlay, #btn_cancel').click( function(){ // Close modal without action
        $('#modal_form')
            .animate({opacity: 0, top: '45%'}, 200,
                function(){
                    $(this).css('display', 'none');
                    $('#overlay').fadeOut(400);
                }
            );
        $('#urledit').css('visibility','hidden') ;
    });

    $('#btn_ok').click( function(){ // Close modal window after button OK pressed

        switch (operationType) {

            case 'DELETE' : {

                dbKey = currentKey['KEY'] ;

                $.ajax({
                    url:'assets/php/del_db_provider.php'
                    , method:'POST'
                    , data:{key : dbKey }
                    , success: function() {
                        callDBList() ;
                    }
                });

                break ;
            }

            case 'COPY' : {

                dbKey = currentKey['KEY'] ;
                dbName = currentKey['NAME'] ;
                dbLink = currentKey['LINK'] ;

                $.ajax({
                    url:'assets/php/put_db_provider.php'
                    , method:'POST'
                    , data:{key : dbKey, name : dbName, link : dbLink }
                    , success: function() {
                        callDBList() ;
                    }
                });

                break ;
            }

            case 'EDIT' : {

                currentKey['LINK'] = getInput() ;

                dbKey  = currentKey['KEY'] ;
                dbName = currentKey['NAME'] ;
                dbLink = currentKey['LINK'] ;

               $.ajax({
                    url:'assets/php/edit_db_provider.php'
                    , method:'POST'
                    , data:{key : dbKey, link : dbLink }
                    , success: function() {
                        callDBList() ;
                    }
                });

                $('#urledit').css('visibility','hidden') ;


                break ;
            }

        }

        $('#modal_form')                                // modal window animation before close
            .animate({opacity: 0, top: '45%'}, 200,
                function() {
                    $(this).css('display', 'none');
                    $('#overlay').fadeOut(400);
                }
            );

    });
    /*------- end of modal window playing ---------------------------------------------*/

    $('.logout-admin-link').click( function(){ // Logout from adminboard

         $.ajax({ url:'assets/php/exit_session.php' });

    });
});



callZipCode();
callDBList() ;











