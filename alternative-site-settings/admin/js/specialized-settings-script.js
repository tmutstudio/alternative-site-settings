jQuery(document).ready(function($) {
    $( 'input[name="altss_uninstall_data_enable"]' ).click(function(){
        if( 'true' === $(this).val() ){
            $( '#data-items-area' ).show();
        }
        else {
            $( '#data-items-area' ).hide();
        }
    });
    $( '.altss-onoffswitch-left input[type="checkbox"]' ).change(function(){
        var textLabel = $(this).closest('.altss-onoffswitch-over').find('.altss-onoffswitch-label-text');
        if( $(this).is(':checked') ){
            textLabel.addClass('darkred-oos');
        }
        else {
            textLabel.removeClass('darkred-oos');
        }
    });
    $( '.altss-onoffswitch-left input[type="checkbox"]' ).each((i,e)=>{
        if( $(e).is(':checked') ) $(e).closest('.altss-onoffswitch-over').find('.altss-onoffswitch-label-text').addClass('darkred-oos');
    });
 });
