$(document).ready(function() {

    var $url = $('#url');
    var $testForm = $('#testForm');
    
    $url.val($testForm.attr('action'));
    
    $url.change(function(){
        $testForm.attr('action', $url.val());
    });
});