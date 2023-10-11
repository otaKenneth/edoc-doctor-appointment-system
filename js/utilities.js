var utils = {
    serializeArrayToJSON: function (serializedArray) {
        var jsonObject = {};
    
        for (var i = 0; i < serializedArray.length; i++) {
            var item = serializedArray[i];
            jsonObject[item.name] = item.value;
        }
    
        return JSON.stringify(jsonObject);
    },
    processElementLogic: function (element, parent, data) {
        var el = $(element)[0];
        if ($(el).is('[logic-loop]')) {
            var clone = $(el).clone();
            $(clone).removeClass('hidden')
            
            data.forEach((row) => {
                $(clone).find('[data-value]').each((k, child_element) => {
                    $(child_element).text(row[$(child_element).attr('data-value')]);
                });
                $(parent).append(clone);
            });
        } else {
            $(el).find('[data-value]').each( (k, child_element) => {
                var $c_el = $(child_element);
                var $el_value = data[$c_el.attr('data-value')];
                if ($c_el.prop('tagName').toLowerCase() === "input") {
                    $c_el.val($el_value);
                } else {
                    $c_el.text($el_value);
                }
            })
        }
    },
    showDialog: function ($element) {
        $element.removeClass('popup-closed');
        $element.addClass('popup-open');
    },
    closeDialog: function ($element) {
        $element.removeClass('popup-open');
        $element.addClass('popup-closed');
    }
};