window.onload = function () {
    alert('xD');
    $.post(ajax_object.ajaxurl, {
        action: 'ajax_action'
    }, function(data) {
        alert(data); // alerts 'ajax submitted'
    });
}