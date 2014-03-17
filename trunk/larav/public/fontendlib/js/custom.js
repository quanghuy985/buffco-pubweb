
jQuery(document).ready(function() {

    jQuery('#subject').change(function() {

        jQuery('#tongtien').text(parseFloat(jQuery('#subject').val()) * parseFloat(jQuery('#totalpriceinput').val()) + '.000 VNĐ');
        // alert(jQuery('#subject').val());
    });
});