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
        var check = false;
        var regexp = new RegExp(pattern);
        return this.optional(element) || regexp.test(value);
    }
);
/*
checks array notation; see effect over checkbox with hidden element
 */
/*
$.extend($.validator.prototype, {
    checkForm: function() {
        this.prepareForm();
        for ( var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++ ) {
            if (this.findByName( elements[i].name ).length != undefined && this.findByName( elements[i].name ).length > 1) {
                for (var cnt = 0; cnt < this.findByName( elements[i].name ).length; cnt++) {
                    this.check( this.findByName( elements[i].name )[cnt] );
                }
            } else {
                this.check( elements[i] );
            }
        }
        return this.valid();
    }
});
*/
