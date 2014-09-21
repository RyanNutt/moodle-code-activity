 
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
        });
        
        jQuery('#id_add_cancel').click(function() {
            jQuery('#ca-add-test').slideUp();
            jQuery('#id_add_test').show();
            jQuery('#id_add_save').hide();
            jQuery('#id_add_cancel').hide(); 
        });
         
    },
    
    ajaxAddTest: function() {
        alert('Add the sucker'); 
    }
}