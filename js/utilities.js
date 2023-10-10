var utils = {
    serializeArrayToJSON: function (serializedArray) {
        var jsonObject = {};
    
        for (var i = 0; i < serializedArray.length; i++) {
            var item = serializedArray[i];
            jsonObject[item.name] = item.value;
        }
    
        return JSON.stringify(jsonObject);
    },
    setValues: function (element, parent, data) {
        var clone = $(element).clone();

        data.forEach((row) => {
            $(clone).find('[data-value]').each((k, el) => {
                $(el).text(row[$(el).attr('data-value')]);
            });
            parent.append(clone);
        });
    }
};