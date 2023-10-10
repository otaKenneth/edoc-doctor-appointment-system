var utils = {
    serializeArrayToJSON: function (serializedArray) {
        var jsonObject = {};
    
        for (var i = 0; i < serializedArray.length; i++) {
            var item = serializedArray[i];
            jsonObject[item.name] = item.value;
        }
    
        return JSON.stringify(jsonObject);
    }
};