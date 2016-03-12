jQuery(document).ready(function () {

    /**
     * Prevent caching when open an ajax modal
     * No cache data loaded to modal popup (by default it's cached)
     */
    $('body').on('hidden.bs.modal', '.modal', function (event) {
        $(this).removeData('bs.modal');
    });

    if (jQuery.validator) {
        addValidatorMethods();
    }

    if(typeof(DATE_FORMAT) == 'undefined' || DATE_FORMAT == '') {
        DATE_FORMAT = 'yyyy-mm-dd';
        if(typeof(toastr) != 'undefined') {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "10000",
                "hideDuration": "0",
                "timeOut": "0",
                "extendedTimeOut": "10000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.error('Nu s-au putut încărca setările pentru afișarea datei.<Br />Vă rugăm să vă relogați, iar dacă problema persistă, contactați echipa tehnică.', 'Eroare fatidică');
        }
    }

    Global.datepickerRefresh();

/*
    $(document).on("click", 'a[data-toggle="modal"]', function (event) {

    });
*/

    $(document).on("click", 'a[data-toggle="modal"].iframe', function (event) {
        var src         = $(this).attr('data-src');
        var height      = $(this).attr('data-height') || 300;
        var width       = $(this).attr('data-width') || 400;
        var title       = $(this).attr('data-modal-title') || 'Modal title here';
        var redirect    = $(this).attr('data-location-on-close') || null;

        $('#iframe-modal .modal-title').html(title);
        $('#iframe-modal .modal-dialog').css({
            'width'         :   parseInt(width)+20,
            'height'        :   parseInt(height)+154
        });

        $('#iframe-modal .modal-content').css({
            'width'         :   parseInt(width)+30,
            'height'        :   parseInt(height)+155
        });

        $("#iframe-modal iframe").attr({
            'src'                       :   src,
            'height'                    :   height,
            'width'                     :   width,
            'data-title'                :   title,
            'data-location-on-close'    :   redirect
        });
        event.preventDefault();
    });

    $('#iframe-modal').on('hidden.bs.modal', function () {
        var redirect  = $('#iframe-modal').attr('data-location-on-close') || null;
        if(redirect !== null) {
            document.location.href = redirect;
        }
    });

    $(document).on("click", 'button[data-href]', function () {
        if ($(this).data('href-target')) {
            var win = window.open($(this).data("href"), '_blank');
            win.focus();
        } else {
            location.href = $(this).data("href");
        }
    });

	$('.dataTable th.sorting, .dataTable th.sorting_asc, .dataTable th.sorting_desc').click(function() {
		var orderBy				= $(this).data('row');
		var orderDirection		= 'ASC';
		var module              = $(this).parents('table').data('module');
        var location            = $(this).parents('table').data('location');

		if(typeof (orderBy) !== 'undefined') {
			// Reorder by another row
			if ($(this).hasClass('sorting')) {
				orderDirection = 'ASC';

			} else if ($(this).hasClass('sorting_asc')) {
				orderDirection = 'DESC';

			} else if ($(this).hasClass('sorting_desc')) {
				orderDirection = 'ASC';
			}

			$.ajax({
				type: "POST",
				url: BASE_URL + '/ajax/change_grid_order',
				data: {class: module, orderBy: orderBy, orderDirection: orderDirection}

			}).done(function(response) {
				r = JSON.parse(response);
				if(r.status === 'OK') {
					window.location.href = location;
				}
			});
		}
	});

    /**
     * Append exclamation icon at the end of requried inputs
     */
    $("form.validate").find('input, textarea, select, file').each(function(index, field) {
        if($(this).attr('required')) {
            if($(this).parent('div').hasClass('input-icon') && $(this).parent('div.input-icon').children('i.fa.fa-exclamation.right').length == 0) {
                $(this).parent('div').prepend('<i class="fa fa-exclamation right tooltips" data-placement="left" data-html="true" data-original-title="Câmp obligatoriu."></i>');
                $('.validate .tooltips').tooltip();
            }

            $(this).bind("change keydown", function(event) {
                ValidateForm.validateInput($(this));
            });
        }
    });

    /**
     * On submit a form with 'validate' class
     */
    $('button[data-action="submit"]').click(function(event) {
        //Prevent the normal submission action
        event.preventDefault();

        // If the form is allready valide
        if($(this).parents('form:first').hasClass('valide')) {
            $(this).parents('form:first').removeClass('validate').submit();

        // The form is not valide, valide it ;)
        } else {
            if(ValidateForm.validate($(this).parents('form:first'))) {
                $(this).parents('form:first').removeClass('validate').submit();
            } else {
                event.preventDefault();
            }
        }
    });
});

var ValidateForm = function() {
    return {
        /**
         * Validate form
         *
         * @param   object  formID
         * @returns boolean
         */
        validate: function(formObject) {
            var errors = 0;
            var firstErrorElement;

            $(formObject).find('input, textarea, select, file').each(function(index, field) {
                if($(this).attr('required') && $(this).is(':visible')) {
                    if($.trim($(this).val()) == '') {
                        ++errors;
                        if(!firstErrorElement) {
                            firstErrorElement = $(this);
                        }

                        $(this).addClass('fieldRequired');
                        ValidateForm.validateInput($(this));
                    }

                    $(this).bind("change keyup", function(event){
                        ValidateForm.validateInput($(this));
                    });
                }
            });

            if(errors > 0) {

                // Direct focus
                if( $('.modal').is(':visible') || (!$('.modal').is(':visible') && $("body").height() <= $(window).height())  ) {
                    ValidateForm.focusEmptyInput(firstErrorElement);

                // Scroll to element, and focus on animation is completed
                } else {
                    // Scoll to first empty imput
                    $('html,body').animate({
                      scrollTop: ( $(firstErrorElement).offset().top - 60 )
                    }, 750, function() {
                       ValidateForm.focusEmptyInput(firstErrorElement);
                    });
                }

                return false;

            } else {
                return true;
            }
        },

        validateInput: function(inputObject) {

            // Add warning
            if($.trim($(inputObject).val()) == '') {

                // Add 'fieldRequired' class to input
                $(inputObject).addClass('fieldRequired');

                //
                if($(inputObject).parent('div').hasClass('input-icon')
                        && $(inputObject).parent('div.input-icon').children('i.fa.fa-exclamation').length == 1) {
                    $(inputObject).parent('div.input-icon').children('i.fa.fa-exclamation').removeClass('fa-exclamation').addClass('fa-warning right');

                } else if($(inputObject).parent('div').hasClass('input-icon') && $(inputObject).parent('div.input-icon').children('i.fa.right').length == 0) {
                    $(inputObject).parent('div').prepend('<i class="fa fa-warning right tooltips" data-placement="left" data-html="true" data-original-title="Câmp obligatoriu."></i>');
                    $('.validate .tooltips').tooltip();
                }

            // Remove warning
            } else if($.trim($(inputObject).val()) !== '') {
                $(inputObject).removeClass('fieldRequired');
                if($(inputObject).parent('div').hasClass('input-icon')) {
                    $(inputObject).parent('div.input-icon').children('i.fa.right').trigger('mouseout');
                    $(inputObject).parent('div.input-icon').children('i.fa.right').remove();
                }
            }
        },

        focusEmptyInput: function (firstErrorElement) {
            // Focus the input, display the error icon and trigger mouse over (show tooltip)
            $(firstErrorElement).focus();
            $(firstErrorElement).parent('div.input-icon').children('i.fa.right').trigger('mouseover');

            // After xTime, trigger mouseout from the warning icon (hide tooltip)
            setTimeout(function(){
                $(firstErrorElement).parent('div.input-icon').children('i.fa.right').trigger('mouseout');
            }, 1500);
        }
    };
}();

function addValidatorMethods() {
    $.extend($.validator.messages, {
        required: "Camp obligatoriu",
        email: "Va rugam introduceti o adresa valida de e-mail",
        number: "Va rugam introduceti un numar valid",
        date: "Va rugam introduceti o data valida",
        max: "Va rugam introduceti un numar mai mic sau egal cu {0}",
        min: "Va rugam introduceti un numar mai mare sau egal cu {0}",
        minlength: "Va rugam introduceti cel putin {0} caractere",
        iban: "Va rugam introduceti un IBAN valid",
        integer: "Valoarea introdusa trebuie sa fie intreaga"

    });

    jQuery.validator.addMethod("unique", function(value, element) {
        var result = false;
        var request = $.ajax({
            async: false,
            url: '/check-unique-user',
            type: "get",
            data: {credential: value},
            dataType: 'json',
            beforeSend: function() {
                $("#loading_spinner").show();
            },
            complete: function() {
                $("#loading_spinner").hide();
            }
        });

        request.done(function(response) {
            if (response.unique)
                result = true;
        });

        return result;
    }, "* Aceasta valoare nu este unica");

    jQuery.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) || value.match(typeof param == 'string' ? new RegExp(param) : param);
    }, 'Camp completat necorespunzator.');

    jQuery.validator.addMethod('doesNotMatchRegex', function(value, element, param) {
        return this.optional(element) || !value.match(typeof param == 'string' ? new RegExp(param) : param);
    }, 'Camp completat necorespunzator.');

    jQuery.validator.addMethod('oneOfLengths', function(value, element, param) {
        return this.optional(element) || ($.inArray(value.length, param) >= 0);
    }, 'Lungime incorecta.');

    jQuery.validator.addMethod('telephoneNumberIfRomanian', function(value, element, param) {
        var customError = new function() {
            this.message = '';
        };

        var isRequiredRomanian = function(errorObject) {
            if ($('#isRomanian').is(':checked') || ($('#tara').val() === 'RO')) {
                if ($("input[name='mobil']").val().length == 10 || $("input[name='telefon']").val().length == 10) {
                    if ($("input[name='mobil']").val().length == 10 && $("input[name='telefon']").val().length > 0 &&
                        $("input[name='telefon']").val().length != 10) {
                        if (errorObject.message.length == 0) {
                            errorObject.message = 'Ambele numere introdusetrebuie sa fie de exact 10 cifre';
                        }
                        return false;
                    }
                    if ($("input[name='telefon']").val().length == 10 && $("input[name='mobil']").val().length > 0 &&
                        $("input[name='mobil']").val().length != 10) {
                        if (errorObject.message.length == 0) {
                            errorObject.message = 'Ambele numere introduse trebuie sa fie de exact 10 cifre';
                        }
                        return false;
                    }
                    return true;
                } else {
                    if (errorObject.message.length == 0) {
                        errorObject.message = 'Numarul introdus trebuie sa fie de exact 10 cifre';
                    }
                    return false;
                }
            } else {
                return true;
            }
        };

        var oneOfTwoFieldsFilled = function(errorObject) {
            var result = ($("input[name='mobil']").val().length > 0 || $("input[name='telefon']").val().length > 0)
            if (result === false) {
                errorObject.message = 'Va rugam sa introduceti numarul de telefon fix sau mobil';
            }
            return result;
        };

        var finalResult = oneOfTwoFieldsFilled(customError) && isRequiredRomanian(customError);
        $.validator.messages.telephoneNumberIfRomanian = customError.message;

        return finalResult;
    }, 'Valoare invalida');

    $.validator.addMethod('positiveNumber', function(value, element) {
        return this.optional(element) || Number(value) >= 0;
    }, 'Valoarea introdusa trebuie sa fie pozitiva.');

    $.validator.addMethod("cui_cnp", function(value, element, radiobuttonPersoanaJuridica) {
        if (radiobuttonPersoanaJuridica.is(':checked')) {
            var result = validateCui(value);
            if (!result) {
                $.validator.messages.cui_cnp = 'CUI invalid';
            }
        } else {
            var result = validateCnp(value);
            if (!result) {
                $.validator.messages.cui_cnp = 'CNP invalid';
            }
        }
        return this.optional(element) || result;
    });

    $.validator.addMethod("greaterThanDate", function(value, element, params) {
        return parseDate(value) > parseDate($(params).val());
    }, 'Data de sfarsit trebuie sa fie mai mare decat cea de inceput');

    $.validator.addMethod("cnp", function(value, element) {
        return validateCnp(value);
    }, "CNP invalid");

    $.validator.addMethod("cui", function(cui, element) {
        return validateCui(cui);
    }, "CUI invalid");

    function parseDate(value) {
        var parts = value.match(/(\d+)/g);
        return new Date(parts[2], parts[1]-1, parts[0]);
    }

    function validateCnp(value) {
        var check = false;
        var re = /^\d{1}\d{2}(0[1-9]|1[0-2])(0[1-9]|[12]\d|3[01])(0[1-9]|[1-4]\d| 5[0-2]|99)\d{4}$/;
        if (re.test(value)) {
            var bigSum = 0, rest = 0, ctrlDigit = 0;
            var control = '279146358279';
            for (var i = 0; i < 12; i++) {
                bigSum += value[i] * control[i];
            }
            ctrlDigit = bigSum % 11;
            if (ctrlDigit == 10) {
                ctrlDigit = 1;
            }

            if (ctrlDigit != value[12]) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    function validateCui(cui) {
        var result = cui.match(/([0-9]+)/);
        var letters = cui.match(/([a-zA-Z]+)/);

        if (!result) {
            return false;
        }
        if ((result.length != 2 || result == null || typeof (result) == null)
            || (letters != null && letters[1].length != 2)) {
            return false;
        } else {
            if ((letters != null) && (letters[1] + result[1] != cui)) {
                return false;
            }
            cui = result[1];
            var cheiaTestare = "753217532";

            if (cui.length < 1 || cui.length > 10) {
                return false;
            }

            var cifraControl = cui.charAt(cui.length - 1);
            var content = cui.substring(0, cui.length - 1);
            while (content.length < 9) {
                content = '0' + content;
            }

            var suma = parseInt(content[0]) * parseInt(cheiaTestare[0])
                + parseInt(content[1]) * parseInt(cheiaTestare[1])
                + parseInt(content[2]) * parseInt(cheiaTestare[2])
                + parseInt(content[3]) * parseInt(cheiaTestare[3])
                + parseInt(content[4]) * parseInt(cheiaTestare[4])
                + parseInt(content[5]) * parseInt(cheiaTestare[5])
                + parseInt(content[6]) * parseInt(cheiaTestare[6])
                + parseInt(content[7]) * parseInt(cheiaTestare[7])
                + parseInt(content[8]) * parseInt(cheiaTestare[8]);

            suma = suma * 10;
            var rest = suma % 11;
            if (rest == 10) {
                rest = 0;
            }

            if (rest == cifraControl) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }
}



var Global = function() {
    return {

        inIframe: function() {
            try {
                return window.self !== window.top;
            } catch (e) {
                return true;
            }
        },

        datepickerRefresh: function() {
            $('.datepicker').datepicker({
                orientation: "left",
                autoclose: true,
                format: DATE_FORMAT,
                // TODO: make it in romanian
            });
        },

        /**
         * @param   string  string
         * @param   integer size
         * @param   string
         * @returns string
         */
        leftPad: function (string, size, pad) {
            var s = string + "";
            while (s.length < size) {
                s = pad + s;
            }
            return s;
        },

        /**
         * Return a random integer between a minum and a maximum value
         *
         * @param   integer min
         * @param   ineger  max
         * @returns integer
         */
        randomIntFromInterval: function (min, max) {
            return Math.floor(Math.random() * (max - min + 1) + min);
        },

        /**
         * @param   object  parent
         * @param   object  child
         * @param   integer
         * @param   booelan
         * @returns null
         */
        citiesByCounty: function(objectParent, childObject, selectedCityID, updateSelectedParendOnChange) {
            $.ajax({
                type: "POST",
                url: BASE_URL + '/ajax/get_cities_by_county',
                data: {
                    countyCode: $(objectParent).val(),
                    selectedCityID: selectedCityID
                }
            }).done(function(response) {
                if(response) {
                    if(response.status === 'OK') {
                        $(childObject).find('option').remove().end().append('<option selected="selected"></option>').end().focus().blur().trigger('chosen:updated');
                        $('.sign-up-cities .select2-chosen').text('Localitate');
                        $('.sign-up-cities a').addClass('select2-default');
                        $.each(response.cities, function(index, value) {
                            if(value.id === selectedCityID) {
                                if(updateSelectedParendOnChange !== true) {
                                    jQuery('#'+ $(objectParent).attr('id') +' option[value='+ value.code +']').attr('selected','selected').trigger('change');
                                }
                                $('.sign-up-cities .select2-chosen').text(value.name);
                                $('.sign-up-cities a').removeClass('select2-default');
                                $(childObject).append('<option value="'+ value.id +'" selected="selected">'+ value.name +'</option>');
                            } else {
                                $(childObject).append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            }
                        });
                        $(childObject).trigger('chosen:updated');
                    }
                }
            });

            setTimeout(function(){
                jQuery('#'+ $(childObject).attr('id') +' option[value='+ selectedCityID +']').attr('selected','selected').trigger('change');
            }, 1000);
        },

        courtsByStage: function(objectParent, childObject, selectedSectionID, updateSelectedParendOnChange) {
            $.ajax({
                type: "POST",
                url: BASE_URL + '/ajax/get_courts_by_stage',
                data: {
                    stage_id:           $(objectParent).val(),
                    selectedSectionID:  selectedSectionID
                }
            }).done(function(response) {
                if(response) {
                    $(childObject).find('option').remove().end().append('<option selected="selected"></option>').end().focus().blur().trigger('chosen:updated');
                    $('.court-by-stage .select2-chosen').text('-- Selectati --');
                    $('.court-by-stage a').addClass('select2-default');
                    if(response.status === 'OK') {
                        $.each(response.courts, function(index, value) {
                            if(value.id === selectedSectionID) {
                                if(updateSelectedParendOnChange !== true) {
                                    jQuery('#'+ $(objectParent).attr('id') +' option[value='+ value.code +']').attr('selected','selected').trigger('change');
                                }
                                $('.court-by-stage .select2-chosen').text(value.name);
                                $('.court-by-stage a').removeClass('select2-default');
                                $(childObject).append('<option value="'+ value.id +'" selected="selected">'+ value.name +'</option>');
                            } else {
                                $(childObject).append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            }
                        });
                        $(childObject).trigger('chosen:updated');
                    }
                }
            });

            setTimeout(function(){
                jQuery('#'+ $(childObject).attr('id') +' option[value='+ selectedSectionID +']').attr('selected','selected').trigger('change');
            }, 1000);
        },

        /**
         * @param   object  parent
         * @param   object  child
         * @param   integer
         * @param   booelan
         * @returns null
         */
        sectionsByCourt: function(objectParent, childObject, selectedSectionID, updateSelectedParendOnChange) {
            $.ajax({
                type: "POST",
                url: BASE_URL + '/ajax/get_sections_by_court',
                data: {
                    court_id:           $(objectParent).val(),
                    selectedSectionID:  selectedSectionID
                }
            }).done(function(response) {
                if(response) {
                    $(childObject).find('option').remove().end().append('<option selected="selected"></option>').end().focus().blur().trigger('chosen:updated');
                    $('.section-by-court .select2-chosen').text('-- Selectati --');
                    $('.section-by-court a').addClass('select2-default');
                    if(response.status === 'OK') {
                        $.each(response.sections, function(index, value) {
                            if(value.id === selectedSectionID) {
                                if(updateSelectedParendOnChange !== true) {
                                    jQuery('#'+ $(objectParent).attr('id') +' option[value='+ value.code +']').attr('selected','selected').trigger('change');
                                }
                                $('.section-by-court .select2-chosen').text(value.name);
                                $('.section-by-court a').removeClass('select2-default');
                                $(childObject).append('<option value="'+ value.id +'" selected="selected">'+ value.name +'</option>');
                            } else {
                                $(childObject).append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            }
                        });
                        $(childObject).trigger('chosen:updated');
                    }
                }
            });

            setTimeout(function(){
                jQuery('#'+ $(childObject).attr('id') +' option[value='+ selectedSectionID +']').attr('selected','selected').trigger('change');
            }, 1000);
        }

    };
}();

