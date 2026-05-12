/*global altss_quick_edit_bt */
jQuery(
    function ($) {

        $('#bulk-action-selector-top, #bulk-action-selector-bottom').change(function () {
            var current = $(this);
            var currentParrent = current.parents('.actions');
            $('#wpbody-content').find('.tag-cat-area-over').remove();
            var area = $('<div class="tag-cat-area-over"></div>').html($('#tag-cat-bulk-action-extra-area-over').html());
            if('add_tags' === current.val() ||'detach_tags' === current.val() ) {
                var pos = 'bulk-action-selector-top' === current.attr('id') ? 'top' : 'bottom';
                var label = $('<div class="tag-bulk-action-title" style="color: ' + ('add_tags' === current.val() ? 'green' : 'darkred') + ';">' + 
                ('add_tags' === current.val() ? altss_quick_edit_bt.i18n_adding_tags : altss_quick_edit_bt.i18n_detaching_tags)
                + ':</div>');
                currentParrent.append(area);
                area.css({'position': 'relative'});
                if('bottom' === pos) area.find('.square-arrow-near, .square-arrow-far').css({'top': '-56px'});
                area.find('.tag-cat-bulk-action-extra-area').css({
                    'display': 'block',
                    'top': 'top' === pos ? '14px' : 'auto',
                    'bottom': 'bottom' === pos ? '40px' : 'auto',
                    'left': '60px'
                });
                area.find('.tag-bulk-action-fields-over').css({
                    'display': 'block',
                }).prepend(label);

                area.find('.input-tags').autocomplete({
                    source: function(request, response) {
                        var term = $.trim(request.term);
                        var lastComma = term.lastIndexOf(',');
                        if (lastComma !== -1) {
                            term = $.trim(term.substring(lastComma + 1));
                        }
                        if (term.length < 2) { 
                            response([]);
                            return;
                        }
                        $.get(ajaxurl, {
                            action: 'ajax-tag-search',
                            tax: area.find('input[name="tag_type"]:checked').val(),
                            q: request.term
                        }, function(data) {
                            response(data.split('\n').filter(Boolean));
                        });
                    },
                    minLength: 2,
                    delay: 300,
                    focus: function(event, ui) {
                        return false;
                    },
                    select: function(event, ui) {
                        var $this = $(this);
                        var value = $this.val();
                        var cursorPos = this.selectionStart;
                        
                        var textBeforeCursor = value.substring(0, cursorPos);
                        var textAfterCursor = value.substring(cursorPos);
                        
                        var lastComma = textBeforeCursor.lastIndexOf(',');
                        
                        if (lastComma === -1) {
                            $this.val(ui.item.value + ', ' + textAfterCursor);
                            var newCursorPos = ui.item.value.length + 2;
                            this.setSelectionRange(newCursorPos, newCursorPos);
                        } else {
                            var beforeTag = value.substring(0, lastComma + 1);
                            var afterTag = value.substring(cursorPos);
                            
                            if (!beforeTag.endsWith(' ')) {
                                beforeTag += ' ';
                            }
                            
                            $this.val(beforeTag + ui.item.value + ', ' + afterTag);
                            
                            var newCursorPos = beforeTag.length + ui.item.value.length + 2;
                            this.setSelectionRange(newCursorPos, newCursorPos);
                        }
                        
                        return false;
                    },
                }).on('keydown', function(e) {
                    var $this = $(this);
                    var menu = $this.autocomplete('widget');
                    
                    if (!menu.is(':visible')) return;
                    
                    if (e.keyCode === 40 || e.keyCode === 38) { 
                        var active = menu.find('li.ui-state-active');
                        if (!active.length) {
                            e.preventDefault();
                            
                            if (e.keyCode === 40) {
                                menu.find('li:first').addClass('ui-state-active');
                            } else {
                                menu.find('li:last').addClass('ui-state-active');
                            }
                        }
                        else {
                            if (e.keyCode === 40) {
                                if(active.next().length > 0) {
                                    active.next().addClass('ui-state-active');
                                    active.removeClass('ui-state-active');
                                }
                            } else {
                                if(active.prev().length > 0) {
                                    active.prev().addClass('ui-state-active');
                                    active.removeClass('ui-state-active');
                                }
                            }
                            
                        }
                    }
                });
            }
            else if('to_cats' === current.val() ||'from_cats' === current.val() ) {
                var pos = 'bulk-action-selector-top' === current.attr('id') ? 'top' : 'bottom';
                var label = $('<div class="tag-bulk-action-title" style="color: ' + ('to_cats' === current.val() ? 'green' : 'darkred') + ';">' + 
                ('to_cats' === current.val() ? altss_quick_edit_bt.i18n_to_cats : altss_quick_edit_bt.i18n_from_cats)
                + ':</div>');
                currentParrent.append(area);
                area.css({'position': 'relative'});
                if('bottom' === pos) area.find('.square-arrow-near, .square-arrow-far').css({'top': '-56px'});
                var catAresWidth = 600 < window.outerWidth ? '560px' : window.outerWidth + 'px';
                area.find('.tag-cat-bulk-action-extra-area').css({
                    'display': 'block',
                    'width': catAresWidth,
                    'top': 'top' === pos ? '14px' : 'auto',
                    'bottom': 'bottom' === pos ? '40px' : 'auto',
                    'left': '60px'
                });
                area.find('.cat-bulk-action-fields-over').css({
                    'display': 'block',
                }).prepend(label);
                area.find('#bulk-action-categories-list').attr('data-mode', current.val());
                area.find('.cat-bulk-action-area').attr('id', '__cat-bulk-action-area');
            }    

        });

        $(document).on( 'click', '#bulk-action-categories-list', function(){
            let area = $(this).siblings('.cat-bulk-action-area');
            let mode = $(this).attr('data-mode');
            $(".popup-container").css( {'width': '100%', 'max-width': '96vw', 'height': '90vh', 'padding-top': '10px'} );
            $("#popup_show_bg").show();
            $("#popup-form-wrapper").html(
                '<div class="popup-mess">'+
                    '<div class="span-buttons-over">' +
                    '<img src="' + altss_quick_edit_bt.images_dir_url + '/spinner-2x.gif" />' +
                    '</div>'+
                '</div>'
            );
            var data = {
                action: 'altss_get_categories_list',
                post_type: altss_quick_edit_bt.post_type,
                security: altss_quick_edit_bt.bulk_cat_nonce,
            }
            var url = altss_quick_edit_bt.ajax_url;
            jQuery.post( url, data, function( response ) {
                if( response){
                    $("#popup-form-wrapper").html( 
                        '<div class="categories-modal-content">'+ 
                        '<div class="fields-settings-modal-content-title" style="color: ' + ('to_cats' === mode ? 'green' : 'darkred') + ';">'+
                        altss_quick_edit_bt['i18n_' + mode + '_mark_categories'] +
                        ' --- <input type="button" id="set-categories-to-area-btn" data-area="' + area + '" data-typekey="" value="' + altss_quick_edit_bt.i18n_apply + '" /></div>'+
                        '<div class="categories-modal-content-area">'+ response + '</div>' +
                        '</div>'
                    );
                    var checkBoxes = $('#popup-form-wrapper input[type=checkbox]');
                    checkBoxes.each(function(i, item){
                        if( area.find('span').is('[id=ctg__' + $( this ).val() + ' ]') ){
                            item.checked = true;
                            $( this ).parent().css( {'background-color' : '#bbf385'} );
                        }
                    });
                }
                else {
                    $("#popup-form-wrapper").html(
                        '<div class="popup-mess">'+
                            '<p>' + altss_quick_edit_bt.i18n_err_category_list + '</p>'+
                            '<div class="span-buttons-over">' +
                        '</div>'+
                        '</div>'
                    );
                }
            });

        });

        $(".popup-container").on( "click", "#set-categories-to-area-btn", function(){
            let checkedFields = $( '.popup-container .categories-modal-content-area' ).find( 'input[type="checkbox"]:checked' );
            let area = $(document).find('#__cat-bulk-action-area');
            let fieldArea = $( area );
            let keys = [];
            let catLinkPref =  'post' === altss_quick_edit_bt.post_type ? '/category/' : '/' + altss_quick_edit_bt.post_type + '_cat/';
            fieldArea.html('');
            checkedFields.each(function( i ){
                var rootName = $( this ).parents( 'dl' ).find( 'dt' ).text();
                var rootID = $( this ).parents( 'dl' ).find( 'dt' ).data( 'key' );
                var name = $( this ).parents( 'label' ).data( 'title' );
                
                keys[i] = $( this ).val();
                var parentCats = render_parent_cats( $( this ), rootID );
                fieldArea.append( '<p data-id="' + $( this ).val() + '"><span class="categories-area-root">' + 
                                    rootName + '</span><span> &gt; </span>' + parentCats + 
                                    '<span id="ctg__' + $( this ).val() + '"><a href="' + catLinkPref + $( this ).parent().attr('data-slug') + '/" target="_blank">' + 
                                    name + '</a></span><span class="cat-item-del-btn"><span class="dashicons dashicons-no-alt"></span></span></p>' );
            });
            $("#bulk_cat_ids").val( keys.join( ',' ) );
            
            $("#popup_show_bg").hide();
            $('#popup-form-wrapper').html('');
        });

        function render_parent_cats( el, root ){
            var out = [];
            var parentID = el.parents( 'label' ).data( 'parent' );
            if( parentID && root !== parentID ) {
                var parentName = $( '#cat__' + parentID ).parents( 'label' ).data( 'title' );
                out[0] = '<span class="">' + parentName + '</span><span> &gt; </span>';
                out[1] = render_parent_cats( $( '#cat__' + parentID ), root );
                return out[1] + '' + out[0];
            }
            return '';
        }


        $('.popup-container').on('change', '.categories-modal-content-area input[type="checkbox"]', function () {
            if ($(this).is(':checked')) {
                $(this).parent().css({ 'background-color': '#bbf385' });
            }
            else {
                $(this).parent().removeAttr('style');
            }
        });

        $(document).on('click', '.cat-item-del-btn', function() {
            let parent = $(this).parent();
            let area = parent.parent();
            let items = area.find('p');
            let ids = [];
            items.each(function(i){
                if($(this).attr('data-id') !== parent.attr('data-id')) ids.push($(this).attr('data-id'));
            });
            $(this).parent().remove();
            $("#bulk_cat_ids").val( ids.join( ',' ) );
        });

        $(document).on('click', '.tag-cat-area-over .popup-close-button', function() {
            $(document).find('#bulk-action-selector-top, #bulk-action-selector-bottom').prop('selectedIndex', 0);
            $(document).find('.tag-cat-area-over').remove();
        });

        $("body").on("click", ".popup-close-button, .popup-close-button-span", function () {
            $("#popup_show_bg").hide();
            $('#popup-form-wrapper').html('');
            $(".popup-container").removeAttr('style');
        });

    }
);
