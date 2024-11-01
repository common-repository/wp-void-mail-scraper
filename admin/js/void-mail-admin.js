(function($) {
	'use strict';
    // inserted text
	$( '#text_submit' ).on( 'click', function(e){
        // prevent default click functionality
		e.preventDefault();
        $( '.void-overlay' ).fadeIn( 500 );
        // get text from textarea
		var inserted_text = $('#inserted_text').val();
        // create a FormData instance		
        var data = new FormData();
        // append info
        data.append( 'action', 'inserted_text' );
        data.append( 'text', inserted_text );		
		//$('.void-overlay').fadeIn(500);
        // create http request
        var xhr = new XMLHttpRequest();
        // set the type , url, asynchronous
        xhr.open( 'POST', ajaxurl, true );        
        xhr.onreadystatechange = function() {
           if ( xhr.readyState == 4 && xhr.status == 200 ) {
            $('.void_mail_number').append( JSON.parse( xhr.responseText ) );
            $('.void_mail_number').append( '<div class="wpvms_done">Successfully Scrapped</div>' );
            $( '.void-overlay' ).fadeOut( 500 );
           }
        };
        // send data
        xhr.send( data );       
		
	});

    // file upload
	$( '.void_mail_upload_btn' ).on( 'click', function(e){
       // prevent default click functionality
	   e.preventDefault();
       // get all selected files
	   var files = $( '.void_mail_upload' ).prop( 'files' );
	   // loop to call each file using ajax
	   $.each ( files, function( key , file ){
            // create a FormData instance   		
	   		var form = new FormData();            
            // append the the file	   			   		
   			form.append( 'file', file ); 
            // if file is .pdf       	
        	if( file.type == 'application/pdf'){
                // action name
        		form.append( 'action', 'pdf_parser' );
                //create new XMLHttpRequest
                var xhr = new XMLHttpRequest();
                //type, url, asynchronous
                xhr.open( 'POST', ajaxurl, true ); 
                // on progress print the current data
                xhr.onprogress = function( e ){                   
                    $('.wpvms_file_output').append( JSON.parse( e.currentTarget.responseText ) );
                };               
                xhr.send( form );        		
        	}else{               
                // action name
        		form.append( 'action', 'file_upload' );
                var xhr = new XMLHttpRequest();
                // set the type , url, asynchronous
                xhr.open( 'POST', ajaxurl, true );
                // on progress print the current data
                xhr.onprogress = function( e ){                   
                    $('.wpvms_file_output').append( JSON.parse( e.currentTarget.responseText ) );
                };
                xhr.onreadystatechange = function(){
                    if ( xhr.readyState == 4 && files.length == key + 1 && xhr.status == 200 ) {
                        setTimeout( function(){
                            $( '.wpvms_file_output' ).append('<div class="wpvms_done">ALL Files successfully Scrapped</div>' );
                        }, 3000);                        
                    }
                };               
                xhr.send( form );                 
        	}	
	   }); /*$.each*/           
	});
	
    // verify api key
	$('.void_mail_api_btn').on('click', function(e){
        //prevent default click action
    	e.preventDefault();
        //get api key fron input field  
    	var api_key =  $('.void_mail_api_key').val();
        //set data
        var data = new FormData();
        data.append( 'action', 'set_api' );
        data.append( 'api_key', api_key );
        data.append( 'opt_name', $(this).prev().attr('name') );
    	if( api_key.length!=0 ){
            var xhr = new XMLHttpRequest();
            xhr.open( 'POST', ajaxurl, true );
            xhr.onreadystatechange = function(){
                if( xhr.readyState == 4 && xhr.status == 200 ){
                    var status_selector = $( '.wpvms_status' );
                    if( xhr.responseText == 'true' ){                         
                        status_selector.html( '<div class="wpvms_status_success"><span class="wpvms_sign_success">&#10004;</span> Connected</div>' );
                        status_selector.prepend( '<div class="wpvms_green">Successfully Connected</div>' ); 
                    }else{
                        status_selector.html( '<div class="wpvms_status_error"><span class="wpvms_sign_error">&#10005;</span> Not Connected</div>' );
                        status_selector.prepend( '<div class="wpvms_red"> Wrong API Key </div>' );
                    }
                }
            };
            xhr.send( data );    		
    	}
    });/*.void_mail_api_btn*/

    //mail verifier
    $('.void_mail_verifier').on('click', function(e){
        //prevent default click function
    	e.preventDefault();
        var data = new FormData();
        data.append( 'action', 'void_verifier' );
        data.append( 'number', $('.void_mail_verifier').attr('name') );

        var xhr = new XMLHttpRequest();
        xhr.open( 'POST', ajaxurl, true );
        //get the node
        var output =  $('.wpvms_verifier_output');
        xhr.onprogress = function(e){           
            output.html( e.currentTarget.responseText );
        }    	
    	xhr.send( data );
    });

    //list data table
    $(document).ready(function() {
        //datatable selector
     	var dataTable = $("#wpvms_list");
        var handleDataTableButtons =         
            dataTable.DataTable({
            aaSorting: [[0, 'desc']],   
            dom: "Blfrtip",
              buttons: [
                // csv button functionality               
                {
                  extend: "csv",
                  className: "btn-sm",
                  exportOptions: {
                    // column to export
                    columns: [
                        $('.wpvms_email_list')                       
                    ]
                  }
                },
                
                {
                    text: 'Select All',
	                action: function ( e, dt, node, config ) {
                        //select all unselected item
	                    if( $( '#wpvms_list tbody tr.selected' ).length !=  $( '#wpvms_list tbody tr' ).length){
	                    	$('#wpvms_list tbody tr').addClass('selected');        					
        				}else{
        					$( '#wpvms_list tbody tr' ).removeClass('selected');
        				}
	                    
	                }
            	},
            	//delete duplicate
            	{
                    text: 'Delete Duplicate',
                    action: function(){
                        var data = {
                            action: 'delete_duplicate'
                        };
                        $.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: data,
                            success: function( response ){
                               $( '#wpvms_list' ).load(document.URL +  ' #wpvms_list');
                            },
                            error: function ( error ){
                                console.log( error );
                            }
                        });
                    }
                },                
              ],
              responsive: true,
            });
     
            //toggle select class on single item
            $('#wpvms_list tbody').on( 'click', 'tr', function () {        	
        		$(this).toggleClass( 'selected' );
    		} ); 
            // delete list
            $('#wpvms_list tbody').on('click', '.void-mail-delete', function(e){
                if( confirm(' Are you sure you want to delete ? ') ){
                    //get selected id           
                    var selected_id = [];
                    //delete every selected list and redraw the table
                    $.each( $('.selected .void-mail-id'), function( index, value ){             
                        selected_id[index] = $(this).text();
                        handleDataTableButtons.row( '.selected' ).remove().draw( false );
                    });

                    var ids;
                    if( selected_id.length ){
                        // join every id to pass on
                        ids = selected_id.join();
                    }else{                        
                        console.log( $( this ).closest('tr').find('.void-mail-id') );
                        ids = $( this ).closest('tr').find('.void-mail-id').text();
                        handleDataTableButtons.row().remove().draw( false );
                    }
                    
                    var data = new FormData();
                    data.append( 'ids', ids );
                    data.append( 'action', 'delete_selected' );
                    console.log( ids );
                    // delete from DB
                    if( ids.length ){

                        var xhr = new XMLHttpRequest();
                        xhr.open( 'POST', ajaxurl, true );
                        xhr.onreadystatechange = function(){
                            if( xhr.readyState == 4 && xhr.status == 200 ){
                                console.log( 'Successfully deleted' );
                            }
                        };
                        xhr.send( data );   
                    }else{
                        console.log( 'Cancelled' );
                    }               

            	}else{
            		console.log( 'nothing to delete' );
            	}
            });
     

        $('.wpvms_mailpoet_list').select2();
        $('.mailpoet_list_insert').on( 'click', function(e){
        	e.preventDefault();           
        	var selected_list = $('.wpvms_mailpoet_list').val() || [];
            var data = new FormData();

            if( void_mail_mailpoet_ver.ver == 3){                
                data.append( 'action', 'mailpoet_list_process' );
            }
            else if( void_mail_mailpoet_ver.ver == 2 ){               
                data.append( 'action', 'wysija_list_process' );
            }
            data.append( 'list', selected_list );
            
        	if( selected_list.length ){
        	    console.log('trigerred');
                var xhr = new XMLHttpRequest();
                xhr.open( 'POST', ajaxurl, true );
                xhr.onprogress = function( e ){                    
                    $( '.wpvms_mailpoet_output').html( e.currentTarget.responseText );
                };
                xhr.send( data );        		
        	}
        });

        //crawler
        // declare variable so that it's available within function for aborting
        var crawler_xhr;
        // FormData instance            
        var crawler_data = new FormData();    
        $('.wpvms_crawler').on( 'click', '.wp_void_crawl', function(e){
        	e.preventDefault();
            // get the webiste url
        	var url = $('.wp_void_mail_website').val();
            
            //remove whitespace            
            url = url.trim();
            if( $(this).hasClass( 'wpvms_stop' ) ){
                //if the state not 4 about the request
                if( crawler_xhr.readystate != 4 ){
                    crawler_data.append( 'abort', 1 );
                    // set the type , url, asynchronous
                    crawler_xhr.open( 'POST', ajaxurl, true );
                    crawler_xhr.send(crawler_data);
                    //abort the xhr request
                    crawler_xhr.abort();
                    //reset the button
                    $(this).removeClass( 'wpvms_stop' );
                    //set the text
                    $(this).val( 'Crawl' );
                    $( ".void_mail_found" ).html( '<div class="wpvms_red">Crawling Aborted</div>' ); 
                }
            }else{
                if( url.length ){  
                    
                    //action name
                    crawler_data.append( 'action', 'website_crawl' );
                    crawler_data.append( 'abort', 0 );
                    // pass url
                    crawler_data.append( 'url', url );
                    //flag
                    crawler_data.append( 'flag', 0 );
                    // create XMLHttpRequest
                    crawler_xhr = new XMLHttpRequest();
                    // set the type , url, asynchronous
                    crawler_xhr.open( 'POST', ajaxurl, true );
                    // print on progress
                    crawler_xhr.onprogress = function( e ){                 
                        $( ".void_mail_found" ).html( e.currentTarget.responseText );
                    };
                    crawler_xhr.onreadystatechange = function( e ){
                        if( crawler_xhr.readyState == 4 ){
                            $( ".void_mail_found" ).html( crawler_xhr.responseText );
                        }
                        
                    }
                    //send data             
                    crawler_xhr.send( crawler_data );
                    //add stop clas to abort
                    $( this ).addClass( 'wpvms_stop' ); 
                    //change the button text
                    $(this).val( 'Abort' );            
                }
            }
            
        	      	
        	
        });/*.wp_void_crawl*/
        
      });//document.ready

    
      
})( jQuery );