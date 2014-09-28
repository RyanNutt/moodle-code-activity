 
var codeActivity = {
    
    ajaxURL: false,
    
    initEdit: function() {
        
        jQuery('#id_add_save').hide();
        jQuery('#id_add_cancel').hide(); 
        jQuery('#id_add_save').click(function() {
            jQuery.ajax(codeActivity.ajaxURL,
                {
                    data: {
                        uniq: jQuery('input[name=ca_temp_code]').val(),
                        activityID: jQuery('input[name=coursemodule]').val(),
                        testType: jQuery('#id_testtype').val(),
                        testCode: jQuery('#id_unittestcode').val(),
                        expectedOutput: jQuery('#id_expectedoutput').val(),
                        convertNulls: jQuery('#id_convertnulls').val(),
                        ignoreWhitespace: jQuery('#id_ignorewhitespace').val(),
                        name: jQuery('#id_testname').val(),
                        action: 'add',
                        sessKey: jQuery('input[name=sesskey]').val()
                    },
                    type: 'POST'
                }
            )
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
            })
 
        });
        
        jQuery('#id_testtype').change(function() {
            jQuery('#ca-unittestcode, #ca-outputmatching').hide();
            if ('outputmatch' == jQuery(this).val()) {
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
            console.info(ace.edit('ace_id_unittestcode')); 
        });
        jQuery('#id_language').click(function() { jQuery(this).change(); });
        jQuery('#id_language').change(); 
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
        console.info(jQuery('input[name=files_readonly]').val());
        console.info(jQuery('input[name=files_student]').val());
        console.info(jQuery('input[name=files_extra]').val()); 
    },
    
    ajaxAddTest: function() {
        alert('Add the sucker'); 
    }
}