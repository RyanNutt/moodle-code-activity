 
var codeActivity = {
    
    ajaxURL: false,
    
    /** Used to hold language strings for individual pages */
    lang: {}, 
    
    initEdit: function() {
        
        jQuery('#id_add_save').hide();
        jQuery('#id_add_cancel').hide(); 
        jQuery('#id_add_save').click(function() {
            codeActivity.ajaxAddTest();
        });
        jQuery('#id_add_test').click(function() {
            jQuery('#ca-add-test').slideDown(); 
            jQuery('#id_add_test').hide();
            jQuery('#id_add_save').show();
            jQuery('#id_add_cancel').show(); 
            codeActivity.updateFileList();
        });
        
        jQuery('#id_add_cancel').click(function() {
            jQuery('#ca-add-test').slideUp();
            jQuery('#id_add_test').show();
            jQuery('#id_add_save').hide();
            jQuery('#id_add_cancel').hide(); 
            codeActivity.resetAddForm();
        });
        ace.config.set('basePath', M.cfg.wwwroot + '/mod/codeactivity/js/ace'); 
        jQuery('#id_expectedoutput, #id_unittestcode').each(function () {
            var textarea = jQuery(this);
            
            var editDiv = jQuery('<div>', {
                position: 'absolute',
                width: '100%', //textarea.width(),
                height: 250, //textarea.height(),
                class: textarea.attr('class'),
                id: 'ace_' + jQuery(this).attr('id')
            }).insertBefore(textarea);
 
            textarea.css('visibility', 'hidden');
            //console.info(editDiv[0]); 
            var editor = ace.edit(editDiv[0]);
            editor.renderer.setShowGutter(true);
            editor.getSession().setValue(textarea.val());
            editor.getSession().setMode("ace/mode/plain_text");
            editor.setOptions({
                fontSize: '1.25em'
            });
            // editor.setTheme("ace/theme/idle_fingers");
            
            // copy back to textarea on form submit...
            textarea.closest('form').submit(function () {
                textarea.val(editor.getSession().getValue());
            });
            editor.on('change', function() {
                textarea.val(editor.getSession().getValue()); 
            });
 
        });
        
        jQuery('#id_testtype').change(function() {
            jQuery('#ca-unittestcode, #ca-outputmatching').hide();
            if ('output' == jQuery(this).val()) {
                codeActivity.updateFileList();
                jQuery('#ca-outputmatching').show();
            } 
            else {
                jQuery('#ca-unittestcode').show(); 
            }
        });
        jQuery('#id_testtype').click(function() {jQuery(this).change(); });
        jQuery('#id_testtype').blur(function() {jQuery(this).click(); });
        jQuery('#id_testtype').change(); 
        
        jQuery('#id_language').change(function() {
            var lang = jQuery(this).val();
             
            if ('java' == lang) {
                ace.edit('ace_id_unittestcode').getSession().setMode('ace/mode/java');
            }
            else if ('py2' == lang || 'py3' == lang) {
                ace.edit('ace_id_unittestcode').getSession().setMode('ace/mode/python'); 
            }
            //console.info(ace.edit('ace_id_unittestcode')); 
        });
        jQuery('#id_language').click(function() { jQuery(this).change(); });
        jQuery('#id_language').change(); 
        codeActivity.resetTestIcons();
        //console.info(window); 
         
    },
    
    updateFileList: function() {
        jQuery.ajax(codeActivity.ajaxURL, {
            data: {
                sessKey: jQuery('input[name=sesskey]').val(),
                action: 'listFiles',
                draftIDs: jQuery('input[name=files_readonly]').val() + "," + jQuery('input[name=files_extra]').val() + "," + jQuery('input[name=files_student]').val()
            },
            type: 'POST',
            success: function(data, status, xhr) {
                if (data.files) {
                    $('#id_runfile')
                        .find('option')
                        .remove()
                    ;
                    $.each(data.files, function (index, value) {
                        $('#id_runfile').append($('<option/>', { 
                            value: value,
                            text : value 
                    }));
}); 
                }
            }
        });
    },
    
    ajaxAddTest: function() {  
        if (jQuery('#id_testname').val().trim() == '') {
            alert(codeActivity.lang.empty_name);
            jQuery('#id_testname').focus();
            return; 
        }
        
        // Check for empty unittest code if using unittesting
        if ('unittest' == jQuery('#id_testtype').val() && jQuery('#id_unittestcode').val().trim() == '') {
            alert(codeActivity.lang.empty_test_code);
            return; 
        }
        
        jQuery.ajax(codeActivity.ajaxURL,   {
            data: {
                sessKey:            jQuery('input[name=sesskey]').val(),
                action:             'addTest',
                test_name:          jQuery('#id_testname').val(),
                test_type:          jQuery('#id_testtype').val(),
                unittest_code:      jQuery('#id_unittestcode').val(),
                run_file:           jQuery('#id_runfile').val(),
                expected_output:    jQuery('#id_expectedoutput').val(),
                convert_nulls:      jQuery('#id_convertnulls').val(),
                ignore_whitespace:  jQuery('#id_ignorewhitespace').val(),
                temp_id:            jQuery('input[name=ca_temp_code]').val()
            },
            type: 'POST',
            success: function(data, status, xhr) {
                if (data.status) {
                    jQuery('#ca-tests').append(data.html);
                    //codeActivity.resetAddForm(); 
                    jQuery('#id_add_cancel').click(); 
                }
            }
        })
    },
    
    resetAddForm: function() {          
        jQuery('#id_testname').val('');
        jQuery('#id_testtype').val('unittest');
        jQuery('#id_unittestcode').val('');
        jQuery('#id_runfile').val('');
        jQuery('#id_convertnulls').val('0');
        jQuery('#id_ignorewhitespace').val('0');
        ace.edit('ace_id_unittestcode').getSession().setValue('');  
    },
    
    deleteTest: function(id) { 
        if (confirm('Are you sure you want to delete this test')) {
            alert('Deleting #' + id);
        }
    },
    
    editTest: function(id) { 
        alert('Editing activity #' + id); 
    },
    
    /* Detach and reattach click handlers to the edit buttons */
    resetTestIcons: function() {
        jQuery('#ca-tests img').off('click');
        jQuery('#ca-tests img.ca-trash').click(function(event) { codeActivity.deleteTest(jQuery(event.target).data('id')); });
        jQuery('#ca-tests img.ca-edit').click(function() { codeActivity.editTest(jQuery(event.target).data('id')); });
    }
}