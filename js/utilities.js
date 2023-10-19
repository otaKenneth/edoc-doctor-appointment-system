var utils = {
    data: [],
    operator: "",
    serializeArrayToJSON: function (serializedArray) {
        var jsonObject = {};
    
        for (var i = 0; i < serializedArray.length; i++) {
            var item = serializedArray[i];
            jsonObject[item.name] = item.value;
        }
    
        return JSON.stringify(jsonObject);
    },
    processLoop: function (loop_el) {
        loop_el.each((k, el) => {
            var loop_key = $(el).attr('logic-loop');
            
            if (loop_key !== '') {
                this.processElementLogic($(el), this.data[loop_key])
            } else {
                this.processElementLogic($(el), null)
            }
        })
    },
    processCondition: function (if_el) {
        if_el.each((k, el) => {
            var loop_key = $(el).attr('logic-loop');
            
            if (loop_key !== '' && typeof(this.data[loop_key]) !== "undefined") {
                this.data = this.data[loop_key];
            }

            if ($(el).is('[logic-if]')) {
                var condition = $(el).attr("logic-if");
                var result = eval(condition);
                
                // console.log(el, loop_key, condition, result, this.data)
                if (result) {
                    $(el).removeClass("hidden");
                    if (loop_key !== '') {
                        this.processLoop($(el));
                    }
                } else {
                    $(el).addClass("hidden");
                }
            } else {
                this.processElementLogic($(el))
            }
        })
    },
    processValues: function(el) {
        if ($(el).is('[logic-loop]')) {
            var parent = $(el).parent()[0];
            
            // hide first element
            $(el).addClass('hidden');
            $(parent).find('.loop-clone').remove();
            
            setTimeout(() => {
                this.data.forEach((row) => {
                    var clone = $(el).clone();
                    
                    $(clone).find('[data-value]').each((k, child_element) => {
                        $(child_element).text(row[$(child_element).attr('data-value')]);
                    });
                    // show clones
                    $(clone).removeClass('hidden')
                    $(clone).addClass('loop-clone')
                    
                    $(parent).append(clone);
                });
            }, 300);
        } else if ($(el).is('[logic-key]')) {
            var objKey = $(el).attr('logic-key');
            $(el).find('[data-value]').each( (k, child_element) => {
                var $c_el = $(child_element);
                var $el_value = this.data[objKey][$c_el.attr('data-value')];
                if ($c_el.prop('tagName').toLowerCase() === "input") {
                    $c_el.val($el_value);
                } else {
                    $c_el.text($el_value);
                }
            })
        } else {
            $(el).find('[data-value]').each( (k, child_element) => {
                var $c_el = $(child_element);
                var $el_value = this.data[$c_el.attr('data-value')];
                if ($c_el.prop('tagName').toLowerCase() === "input") {
                    $c_el.val($el_value);
                } else {
                    $c_el.text($el_value);
                }
            })
        }
    },
    processElementLogic: function (element, data = null) {
        if (data !== null) {
            this.data = data;
        }

        element.each((k, el) => {
            var has_logic_count = $(el).find(".has-logic").length;

            if (has_logic_count > 0) {
                $(el).find(".has-logic").each((k, e) => {
                    var $el = $(e);
                    if ($el.is('[logic-loop]') && $el.is('[logic-if]')) {
                        this.processCondition($el);
                    } else if ($el.is('[logic-loop]')) {
                        this.processLoop($el);
                    } else if ($el.is('[logic-if]')) {
                        this.processCondition($el);
                    } else if ($el.is('[logic-key]')) {
                        this.processValues($el);
                    } else {
                        this.processValues($el);
                    }
                });
            } else {
                this.processValues(el);
            }
        })
    },
    showDialog: function ($element) {
        $element.removeClass('popup-closed');
        $element.addClass('popup-open');
    },
    closeDialog: function ($element) {
        $element.removeClass('popup-open');
        $element.addClass('popup-closed');
    },
    logFormValues: function (inputname, datatype, val) {
        let result = {
            'currVal': '',
            'prevVal': val
        };

        if (typeof form.changes[inputname] == "undefined") {
            form.changes = {...form.changes, [inputname]:result};
        } else {
            form.changes[inputname][datatype] = val;
        }

    },
    processEditableValues: function (inputname, datatype, prevVal) {
        let result = {
            'currVal': '',
            'prevVal': prevVal
        };

        if (result.prevVal != '') {
            switch (datatype) {
                case "date":
                    let tempObjDate = new Date(result.prevVal);
                    result.currVal = (tempObjDate.getMonth()+1) + '/' + tempObjDate.getDate() + '/' + tempObjDate.getFullYear();
                    break;
            
                default:
                    result.currVal = prevVal;
                    break;
            }
        }

        return result;
    },
    pageReload: function (time) {
        setTimeout(() => {
            location.reload();
        }, time)
    }
};