$.validator.addMethod("in_array", function(value, element, haystack) {
    return (haystack.indexOf(value) !== -1);
});