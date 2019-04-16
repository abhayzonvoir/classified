jQuery(document).ready(function($){
    $('#arianna_final_score').attr('readonly', true);
    $('#arianna_review .inside .rwmb-meta-box > div:gt(0)').wrapAll('<div class="arianna_enabled-review">');
    $('.arianna_enabled-review > div:gt(0):even:lt(6)').each(function() {
        $(this).prev().addBack().wrapAll($('<div/>',{'class': 'arianna_criteria'}));
    });
    var ariannaReviewCheckbox = $('#arianna_review_checkbox'),
    ariannaReviewBox = $('.arianna_enabled-review');

    if ( ariannaReviewCheckbox.is(":checked") ) {
            ariannaReviewBox.show();
        }
        
    ariannaReviewCheckbox.click(function(){
        ariannaReviewBox.slideToggle('slow');
    });
    function arianna_AvrScore() { 
        var i = 0;
        var arianna_cs1=0, arianna_cs2=0, arianna_cs3=0, arianna_cs4=0, arianna_cs5=0, arianna_cs6=0;
        
        var arianna_ct1 = $('input[name=arianna_ct1]').val();
        var arianna_ct2 = $('input[name=arianna_ct2]').val();
        var arianna_ct3 = $('input[name=arianna_ct3]').val();
        var arianna_ct4 = $('input[name=arianna_ct4]').val();
        var arianna_ct5 = $('input[name=arianna_ct5]').val();
        var arianna_ct6 = $('input[name=arianna_ct6]').val();          
        if (arianna_ct1) { i+=1; arianna_cs1 = parseFloat($('input[name=arianna_cs1]').val()); } else { arianna_ct1 = null; }
        if (arianna_ct2) { i+=1; arianna_cs2 = parseFloat($('input[name=arianna_cs2]').val()); } else { arianna_ct2 = null; }
        if (arianna_ct3) { i+=1; arianna_cs3 = parseFloat($('input[name=arianna_cs3]').val()); } else { arianna_ct3 = null; }
        if (arianna_ct4) { i+=1; arianna_cs4 = parseFloat($('input[name=arianna_cs4]').val()); } else { arianna_ct4 = null; }
        if (arianna_ct5) { i+=1; arianna_cs5 = parseFloat($('input[name=arianna_cs5]').val()); } else { arianna_ct5 = null; }
        if (arianna_ct6) { i+=1; arianna_cs6 = parseFloat($('input[name=arianna_cs6]').val()); } else { arianna_ct6 = null; }
        var arianna_Total = (arianna_cs1 + arianna_cs2 + arianna_cs3 + arianna_cs4 + arianna_cs5 + arianna_cs6);
        var arianna_FinalScore = Math.round((arianna_Total / i)*10)/10;
        
        $("#arianna_final_score").val(arianna_FinalScore);
        
        if ( isNaN(arianna_FinalScore) ) { $("#arianna_final_score").val(''); }
    }
    $('.rwmb-input').on('change', arianna_AvrScore);
    $('#arianna_cs1, #arianna_cs2, #arianna_cs3, #arianna_cs4, #arianna_cs5, #arianna_cs6, #arianna_author_score').on('slidechange', arianna_AvrScore);
});