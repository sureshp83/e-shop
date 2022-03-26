$(document).on('keypress', '.notAllowSpace', function(evt, value) {

if (evt.which === 32)
    return false;
});

$(document).on("keypress", '.numeric', function(evt, value) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
});

$(document).on("keypress", '.decimalOnly', function(evt) {

    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
});

$('.alphawithspecialchar').keypress(function(e) {
    var regex = new RegExp("^[a-zA-Z- _ &]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

jQuery.validator.addMethod("alphawithspecialchar", function(value, element) {

    return this.optional(element) || /^[a-zA-Z- _ &]+$/i.test(value);
}, "Letters, dash ,space , underscore and & only ");


$.validator.addClassRules("alphawithspecialchar", {

    alphawithspecialchar: true

});


$('.alphaOnly').keypress(function(e) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

jQuery.validator.addMethod("alphaOnly", function(value, element) {

    return this.optional(element) || /^[a-zA-Z ]+$/i.test(value);
}, "Letters only please");


$.validator.addClassRules("alphaOnly", {

    alphaOnly: true

});

$('.alphanumeric').keypress(function(e) {
    var regex = new RegExp("^[a-zA-Z0-9 -]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});


jQuery.validator.addMethod("alphanumeric", function(value, element) {

    return this.optional(element) || /^[a-zA-Z0-9 -]+$/i.test(value);
}, "Letters, numbers only please");


$.validator.addClassRules("alphanumeric", {

    alphanumeric: true

});

// small char with dash only     
$('.smallCharWithDash').keypress(function(e) {
    var regex = new RegExp("^[a-z- ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});


jQuery.validator.addMethod("smallCharWithDash", function(value, element) {

    return this.optional(element) || /^[a-z- ]+$/i.test(value);
}, "Letters and dash only please");


$.validator.addClassRules("smallCharWithDash", {

    smallCharWithDash: true

});


// small char with dash only     
$('.smallCapsCharWithDash').keypress(function(e) {
    var regex = new RegExp("^[a-zA-Z- ]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});


jQuery.validator.addMethod("smallCapsCharWithDash", function(value, element) {

    return this.optional(element) || /^[a-zA-Z- ]+$/i.test(value);
}, "Letters and dash only please");


$.validator.addClassRules("smallCapsCharWithDash", {

    smallCapsCharWithDash: true

});

// number with colan    
$('.numberWithCollan').keypress(function(e) {
    var regex = new RegExp("^[0-9:]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {

        return true;
    }

    e.preventDefault();
    return false;
});

jQuery.validator.addMethod("numberWithCollan", function(value, element) {

    return this.optional(element) || /^[[0-9:]+$/i.test(value);
}, "Number and collan only");

$.validator.addClassRules("numberWithCollan", {

    numberWithCollan: true

});


jQuery.validator.addMethod("numericOnly", function(value, element) {

    return this.optional(element) || /^(0|[1-9][0-9]*)$/i.test(value);
}, "Please enter only number");

$.validator.addClassRules("numericOnly", {

    numericOnly: true

});


jQuery.validator.addMethod("decimal", function(value, element) {

    return this.optional(element) || /^[1-9]\d*(\.\d+)?$/i.test(value);
}, "Please enter only number");

$.validator.addClassRules("decimal", {

    decimal: true

});

jQuery.validator.addMethod('ckrequired', function(value, element, params) {
    var idname = jQuery(element).attr('id');
    var messageLength = jQuery.trim(CKEDITOR.instances[idname].getData());
    return !params || messageLength.length !== 0;
}, "");
