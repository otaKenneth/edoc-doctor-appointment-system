var active_icon_classes = {
    "Dashboard": "menu-active menu-icon-dashbord-active",
    "Doctors": "menu-active menu-icon-doctor-active",
    "Appointments": "menu-active menu-icon-appoinment-active",
    "Sessions": "menu-active menu-icon-session-active",
    "Schedule": "menu-active menu-icon-schedule-active",
    "Patients": "menu-active menu-icon-patient-active"
};

$(document).ready(function () {
    $('.menu-row').each( (k, el) => {
        var targetEl = $(el).children()[0];
        
        // set active links
        if ($(targetEl).attr('link-name') === active_uri) {
            $(targetEl).addClass(active_icon_classes[active_uri])
            $($(targetEl).children()[0]).addClass('non-style-link-menu-active')
        } else {
            $(targetEl).removeClass(active_icon_classes[$(targetEl).attr('link-name')])
            $($(targetEl).children()[0]).removeClass('non-style-link-menu-active')
        }
    })

    // Close popup
    $('.popup-closer').click((ev) => {
        var dialog = $(ev.currentTarget).closest('.overlay');
        
        $(dialog).removeClass('popup-open');
        $(dialog).addClass('popup-closed');
    })

    // Open Popup
    $('.popup-btn').click((ev) => {
        console.log("clicked")
        var dialog = $(ev.currentTarget).attr('popupdata-id');
        
        if ($(ev.currentTarget).attr('data')) {
            processDialogData($(ev.currentTarget).attr('data'), dialog);
        } else {
            $(`#${dialog}`).removeClass('popup-closed');
            $(`#${dialog}`).addClass('popup-open');
        }
    })
})