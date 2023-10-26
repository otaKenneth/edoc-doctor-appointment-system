var active_icon_classes = {
    "Dashboard": "menu-active menu-icon-dashbord-active",
    "Doctors": "menu-active menu-icon-doctor-active",
    "Appointments": "menu-active menu-icon-appoinment-active",
    "Sessions": "menu-active menu-icon-session-active",
    "Schedule": "menu-active menu-icon-schedule-active",
    "Patients": "menu-active menu-icon-patient-active",
    "Home": "menu-active menu-icon-home-active",
    "Scheduled Sessions": "menu-active menu-icon-patient-active",
    "My Bookings": "menu-active menu-icon-appoinment-active",
    "Settings": "menu-active menu-icon-patient-active",
};
const form = {
    'id': '',
    changes: []
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
        var dialog = $(ev.currentTarget).attr('popupdata-id');
        
        if ($(ev.currentTarget).attr('data')) {
            processDialogData($(ev.currentTarget).attr('data'), dialog);
        } else {
            $(`#${dialog}`).removeClass('popup-closed');
            $(`#${dialog}`).addClass('popup-open');
        }
    })

    // show editing
    $('.editable').click(function (ev) {
        let $el = $(ev.currentTarget);
        if ($el.hasClass('cancellable')) {
            $(ev.currentTarget).removeClass('cancellable');
            $(ev.currentTarget).next().next().addClass('hidden');
            $(ev.currentTarget).next().removeClass('hidden');
        } else {
            $(ev.currentTarget).addClass('cancellable');
            $(ev.currentTarget).next().addClass('hidden');
            $(ev.currentTarget).next().next().removeClass('hidden');
        }
    })

    $('.field-editable').focus(function (ev) {
        let $el = $(ev.currentTarget);

        utils.logFormValues($el.attr('name'), 'prevVal', $el.val());
    })
    
    $('.field-editable').focusout(function (ev) {
        let $el = $(ev.currentTarget);
        let datatype = $el.attr('data-datatype');
        var parent = $el.parent()[0];

        let editableValues = utils.processEditableValues($el.attr('name'), datatype, $el.val());
        utils.logFormValues($el.attr('name'), 'currVal', $el.val());

        $(parent).addClass('hidden');
        $(parent).prev().removeClass('hidden');
        $(parent).prev().prev().removeClass('cancellable');

        if ($el.prop('tagName').toLowerCase() === "input") {
            $(parent).prev().text(editableValues.currVal);
        } else if ($el.prop('tagName').toLowerCase() === "select") {
            console.log("shiiett")
            $(parent).prev().text($el.find('option:selected').text());
        }
    })
})