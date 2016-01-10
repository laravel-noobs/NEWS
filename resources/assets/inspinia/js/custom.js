moment.locale('vi');

toastr.options = {
    "closeButton": true,
    "debug": false,
    "progressBar": true,
    "preventDuplicates": false,
    "positionClass": "toast-top-right",
    "onclick": null,
    "showDuration": "400",
    "hideDuration": "1000",
    "timeOut": "7000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

if(typeof(flash_messages) !== 'undefined')
    if(flash_messages != null)
    for(i = 0; i < flash_messages.length; i++)
        toastr[flash_messages[i]['type']](flash_messages[i]['message'], flash_messages[i]['title'], flash_messages[i]['options']);