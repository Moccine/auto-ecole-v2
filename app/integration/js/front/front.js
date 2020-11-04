var $ = require('jquery');
const $field = $('input, textarea');
var AOS = require('aos');
var selectpicker = require('bootstrap-select');
var select2 = require('select2');
const {getRoute, httpRequest, trans} = require('../common');
var customerDatas = null;
const $customerId = $('form').find(".quotation-form-block").data('customer-id');
//var dt      = require( 'datatables.net' );
var dt = require('datatables.net');

// Main JS
$(document).ready(function () {
    $(function () {
        // Select custom
        $('.quotation-two-section select').select2();
        $('.dt-select2').selectpicker();

        $('#quotation-list-table').DataTable({
            'dom': '',
            drawCallback: function () {
                $('.dt-select2').selectpicker();
            }
        });

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();

        // Customer Select2 Ajax
        var $element = $("select.customer-autocomplete").select2({
            ajax: {
                delay: 250,
                dataType: 'json',
                data: function (term) {
                    return {name: term.term};
                },
                url: getRoute('api_web_customer_search'),
                processResults: function (data) {
                    var customer = data.data;
                    for (var prop in customer) {
                        $(`#quotationStep1_${prop}`).val(customer[prop]);

                    }
                    return {
                        results: $.map(data, function (item) {

                            return {
                                text: item.name,
                                id: item.id,
                                deliveryAddress: item.deliveryAddress,
                                deliveryCity: item.deliveryCity,
                                deliveryPostalCode: item.deliveryPostalCode,
                                deliveryCountry: item.deliveryCountry,
                                address: item.address,
                                city: item.city,
                                postalCode: item.postalCode,
                                country: item.country
                            }
                        })
                    };
                }
            },
            minimumInputLength: 2,
            placeholder: trans('app.title.add_customer'),
            templateSelection: (data) => {
                if (data.id !== undefined && data.id !== '') {
                    const route = getRoute('api_web_get_one_customer', {'id': parseInt(data.id)});
                    $.ajax({
                        url: route,
                        method: 'GET',
                    })
                        .done((data) => {
                            if (isNaN(parseInt($customerId))) {
                                let customer = data.customer;
                                for (var prop in customer) {
                                    $(`#quotationStep1_${prop}`).val(customer[prop]);
                                }
                            }
                        });
                }

                return data.text
            }
        });
        //--------------------------- init customer  field-----------------------------------
        if (!isNaN(parseInt($customerId))) {
            const $customerInitRoute = getRoute('api_web_get_one_customer', {'id': parseInt($customerId)});
            var $request = $.ajax({
                url: $customerInitRoute
            });
            $request.then(function (data) {
                var option = new Option(data.customer.name, data.customer.id, true, true);
                $element.append(option);
                $element.trigger('change');
            });
        }

        // Fix Input Iphone
        if (/iPhone/.test(navigator.userAgent) && !window.MSStream) {
            $field.mousedown(function () {
                $('meta[name=viewport]').remove();
                $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0">');
            });

            $field.focusout(function () {
                $('meta[name=viewport]').remove();
                $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">');
            })
        }

        // Field Focus
        $field.on("focus", function () {
            $(this).parent().addClass('form-group-focus');
        }).on("blur", function () {
            $(this).parent().removeClass('form-group-focus');
        });

        // Check value input login
        $('.content-auth .form-control').each(function () {
            checkForInput(this);
        });

        $('.content-auth .form-control').on('change keyup', function () {
            checkForInput(this);
        });

        function checkForInput(element) {
            const $label = $(element);

            if ($(element).val().length > 0) {
                $label.addClass('has-value');
            } else {
                $label.removeClass('has-value');
            }
        }

        // Detail
        $('body').delegate('.detail-link', 'click', function () {
            $(this).toggleClass('active');
            $(this).parent().next().slideToggle();
        });

        $('#modal-duplicate').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            const quotationId = $(e.relatedTarget).data('quotation-id');
            //populate the textbox
            $(e.currentTarget).find('input[name="quotation-id"]').val(quotationId);
        });
        $('#modal-revision').on('show.bs.modal', function (e) {
            //get data-id attribute of the clicked element
            const quotationId = $(e.relatedTarget).data('quotation-id');
            //populate the textbox
            $(e.currentTarget).find('input[name="quotation-id"]').val(quotationId);
        });

        $('.btnDuplicationConfirm').on('click', function () {
            let type = $(this).data('type');
            let url = '';
            if (type === 'revision') {
                url = getRoute('revision_quotation', {
                    id: $('#modal-revision').find('input[name="quotation-id"]').val()
                });
                window.location = url;
            }
            if (type === 'duplicate') {
                url = getRoute('duplicate_quotation', {
                    id: $('#modal-duplicate').find('input[name="quotation-id"]').val()
                });
                window.location = url;
            }
        });

        // Product
        var productItemLink = $('.product-item-title');
        productItemLink.click(function () {
            $(this).toggleClass('active');
            $(this).next().slideToggle('slow');
        });

        // Input date
        var inputDate = $('.date-group input');
        inputDate.on('keyup', (e) => {
            $(e.target).val($(e.target).val().replace(/[^0-9]/, ''));
            if ($(e.target).val().length >= $(e.target).attr('maxlength')) {
                $(e.target).parent().next().children('input').focus();
            }
        });

        // Input Number
        var numberGroup = $('.form-number-group');
        const minVal = 1;
        numberGroup.each(function () {
            var spinner = $(this),
                input = spinner.find('input[type="number"]'),
                btnUp = spinner.find('.more-link'),
                btnDown = spinner.find('.less-link'),
                min = input.attr('min'),
                max = input.attr('max');

            btnUp.click(function () {
                if (input.val()) {
                    var oldValue = parseFloat(input.val());
                } else {
                    var oldValue = minVal;
                }
                var newVal = oldValue + 1;

                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

            btnDown.click(function () {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                    newVal = newVal < 0 ? minVal : newVal;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
        });
    });
});
