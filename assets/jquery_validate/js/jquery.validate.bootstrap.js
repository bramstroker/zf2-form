$.extend($.validator.prototype, {
    showLabel: function(element, message) {
        var label = this.errorsFor( element );

        if (label.length == 0) {
            var railsGenerated = $(element).next('span.help-inline');
            if (railsGenerated.length) {
                railsGenerated.attr('for', this.idOrName(element))
                railsGenerated.attr('generated', 'true');
                label = railsGenerated;
            }
        }

        if (label.length) {
            // refresh error/success class
            label.removeClass(this.settings.validClass).addClass(this.settings.errorClass);
            // check if we have a generated label, replace the message then
            label.attr('generated') && label.html(message);
        } else {
            // create label
            label = $('<' + this.settings.errorElement + '/>')
                .attr({'for':  this.idOrName(element), generated: true})
                .addClass(this.settings.errorClass)
                .addClass('help-inline')
                .html(message || '');
            if (this.settings.wrapper) {
                // make sure the element is visible, even in IE
                // actually showing the wrapped element is handled elsewhere
                label = label.hide().show().wrap('<' + this.settings.wrapper + '/>').parent();
            }
            if (!this.labelContainer.append(label).length) {
                this.settings.errorPlacement
                    ? this.settings.errorPlacement(label, $(element))
                    : label.insertAfter(element);
            }
        }
        if (!message && this.settings.success) {
            label.text('');
            typeof this.settings.success == 'string'
                ? label.addClass(this.settings.success)
                : this.settings.success(label);
        }
        this.toShow = this.toShow.add(label);
    }
});

/**

 Setting custom validator defaults to work with twitter bootstrap */
$.extend($.validator.defaults, {
    errorClass: 'error',
    validClass: 'success',
    errorElement: 'span',
    highlight: function (element, errorClass, validClass) {
        if (element.type === 'radio') {
            this.findByName(element.name).closest('div.control-group').removeClass(validClass).addClass(errorClass);
        }else {
            $(element).closest('div.control-group').removeClass(validClass).addClass(errorClass);
        }
    },
    unhighlight: function (element, errorClass, validClass) {
        var addon = $(element).parent('div.input-prepend, div.input-append');
        if (element.type === 'radio') {
            $(element).closest('div').parent('div').removeClass(errorClass).addClass(validClass);
        } else {
            $(element).closest('div.control-group').removeClass(errorClass).addClass(validClass);
            $(element).next('span.help-inline').text('');
        }
    },
    errorPlacement: function(error, element) {
        var isInputAppend = ($(element).parent('div.input-append').length > 0);
        var isRadio = ($(element).attr('type') == 'radio');
        var iMultiCheckbox = ($(element).attr('type') == 'checkbox' && $(element).attr('name').endsWith('[]'));
        if (isRadio || iMultiCheckbox) {
            afterElement = $(element).closest('div.controls').children('label').filter(':last');
            error.insertAfter(afterElement);
        }else if (isInputAppend) {
            appendElement = $(element).next('span.add-on');
            error.insertAfter(appendElement);
        }else {
            error.insertAfter(element);
        }
    }
});

String.prototype.endsWith = function(pattern) {
    var d = this.length - pattern.length;
    return d >= 0 && this.lastIndexOf(pattern) === d;
};