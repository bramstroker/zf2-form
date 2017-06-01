$.validator.addMethod("in_array", function(value, element, haystack) {
    var check = ($.inArray(value, haystack) !== -1);

    if(!check) {
        try {
            value = parseInt(value, 10);
        } catch(err) {
            return check;
        }

        check = ($.inArray(value, haystack) !== -1);
    }

    return check;
});

$.validator.addMethod(
    "regex",
    function(value, element, pattern) {
        var regexp = new RegExp(pattern[0], pattern[1]);
        return this.optional(element) || regexp.test(value);
    }
);