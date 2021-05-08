$(document).ready(function() {
    $("#toggle-fullscreen").click(function () {
        $.lintas.fullscreen(document.documentElement);
    });

    //
    $(".date").datepicker({
        format: 'yyyy-mm-dd',
        orientation: "bottom left",
        autoClose: true,
        todayHighlight: true,

    });
    $('.date').on('changeDate', function(ev){
        $(this).datepicker('hide');
    });

    //
    $(".select2").select2();
    $(".select2-multiple").select2({
        placeholder: "Select All",
        tags: true,
        tokenSeparators: [',', ' ']
    });

    //
    $('.summernote').summernote({
        height: 200,
    });

    //
    $(".number-format").autoNumeric('init', {vMin: 0});

    //
    $('.number, .input-harga, .phone, .postal, .only-number').keypress(function(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 48 || charCode > 57))
            return false;
        return true;
    });
});

$(function() {
    $.konveksi = {
        showModal: function (message, options) {
            var settings = $.extend({
                // These are the defaults.
                haveHeader: false,
                haveFooter: false,
                headerText: '',
                footerAction: {}
            }, options);

            var modalContainer = jQuery('<div>').addClass('modal');
            var modalDialog = jQuery('<div>').addClass('modal-dialog');
            var modalContent = jQuery('<div>').addClass('modal-content');
            modalDialog.append(modalContent);
            modalContainer.append(modalDialog);
            var modalHeader = jQuery('<div>').addClass('modal-header');
            var modalBody = jQuery('<div>').addClass('modal-body');
            var modalFooter = jQuery('<div>').addClass('modal-footer');
            modalBody.append(message);
            if (settings.haveHeader) {
                modalHeader.html(settings.headerText);
                modalContent.append(modalHeader);
            }
            modalContent.append(modalBody);
            if (settings.haveFooter) {
                modalContent.append(modalFooter);
            }

            $('body').append(modalContainer);
            var modalOptions = {
                complete: function () {
                    modalContainer.remove();
                }
            };
            modalContainer.modal(modalOptions);
            modalContainer.modal();
        },
        reloadSection: function (selector, url, method, dataAddition, callback) {
            if (!method)
                method = "get";
            var element = jQuery(selector);
            var xhr = element.data('xhr');
            if (xhr) {
                xhr.abort();
            }

            if (!dataAddition) {
                dataAddition = {};
            }

            var elementHeight = element.height();
            $.evy.blockElement(element);
            //element.append('<div class="preloader loading valign-wrapper" style="height:' + elementHeight + 'px"><div class="progress"><div class="indeterminate"></div></div></div>');
            element.addClass('loading');
            element.data('xhr', jQuery.ajax({
                type: method,
                url: url,
                dataType: 'json',
                data: dataAddition,
                success: function (data) {
                    $.lintas._handle_response(data, function () {
                        if (data.ajaxData && data.ajaxData.redirectTo) {
                            window.location.href = data.ajaxData.redirectTo;
                            return;
                        }
                        jQuery(selector).html(data.html);
                        if (data.js && data.js.length > 0) {
                            var script = $.lintas.base64.decode(data.js);
                            eval(script);
                        }

                        element.removeClass('loading');
                        element.data('xhr', false);

                        if (typeof callback === "function") {
                            // Call it, since we have confirmed it is callable?
                            callback(data);
                        }

                    });
                },
                error: function (obj, t, msg) {
                    if (msg != 'abort') {
                        $.evy.showToast('error', 'Error, please call administrator... (' + msg + ')');
                    }
                },
                complete: function () {
                    $.evy.unblockElement(element);
                }
            }));
        },
        blockElement: function (selector) {
        },
        unblockElement: function (selector) {
        },
        showToast: function (messageType, message, completeCallback) {
            $.konveksi.showModal(message);
        },
        provinceControl: function (opt) {
            var select2 = typeof opt.select2 == 'undefined' ? false : opt.select2;
            var provinceSelector = typeof opt.province_selector == 'undefined' ? '#province_id' : opt.province_selector;
            var citySelector = typeof opt.city_selector == 'undefined' ? '#city_id' : opt.city_selector;
            var districtsSelector = typeof opt.districts_selector == 'undefined' ? '#districts_id' : opt.districts_selector;
            $(provinceSelector).change(function (evt) {
                evt.preventDefault();
                var province_id = $(this).val();
                /* get the action attribute from the <form action=""> element */
                //var url = ;
                var data = {province_id: province_id};
                /* Send the data using post with element id name and name2*/
                if (select2) {
                    $(citySelector).select2("enable", false);
                } else {
                    $(citySelector).attr('disabled', 'disabled');
                }

                var url = APP_URL + '/api/city';
                var xhr = $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function (data) {
                        var msg;
                        if (data.err_code > 0) {
                            $.konveksi.showModal('Error', data.err_message);
                        } else {
                            if (select2) {
                                $(citySelector).select2('destroy');
                            }
                            $(citySelector).empty();
                            for (var i in data) {
                                var row = data[i];
                                $(citySelector).append($('<option>').attr('value', row.id).append(row.name));
                            }
                            if (select2) {
                                $(citySelector).select2();
                            }
                            $.konveksi.cityControl(opt);
                            $(citySelector).trigger("change");
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert('Unexpected error [Get City]');
                    },
                    complete: function () {
                        if (select2) {
                            $(citySelector).select2("enable");
                        } else {
                            $(citySelector).removeAttr('disabled');
                        }
                    }
                });
                return true;
            });
        },
        cityControl: function (opt) {
            var select2 = typeof opt.select2 == 'undefined' ? false : opt.select2;
            var citySelector = typeof opt.city_selector == 'undefined' ? '#city_id' : opt.city_selector;
            //var districtsSelector = typeof opt.districts_selector == 'undefined' ? '#districts_id' : opt.districts_selector;
            $(citySelector).change(function (evt) {
                evt.preventDefault();
                //var city_id = $(this).val();

                /* get the action attribute from the <form action=""> element */
                //var url = ;
                //var data = {city_id: city_id};
                /* Send the data using post with element id name and name2*/
                //if (select2) {
                    //$(districtsSelector).select2("enable", false);
                //} else {
                    //$(districtsSelector).attr('disabled', 'disabled');
                //}

                //var url = APP_URL + '/api/districts';
                // var xhr = $.ajax({
                //     url: url,
                //     type: "POST",
                //     data: data,
                //     dataType: "json",
                //     success: function (data) {
                //         var msg;
                //         if (data.err_code > 0) {
                //             $.konveksi.showModal('Error', data.err_message);
                //         } else {
                //             if (select2) {
                //                 $(districtsSelector).select2('destroy');
                //             }
                //             $(districtsSelector).empty();
                //             for (var i in data) {
                //                 var row = data[i];
                //                 $(districtsSelector).append($('<option>').attr('value', row.id).append(row.name));
                //             }
                //             if (select2) {
                //                 $(districtsSelector).select2();
                //             }
                //             $(districtsSelector).trigger("change");
                //         }
                //     },
                //     error: function (xhr, ajaxOptions, thrownError) {
                //         alert('Unexpected error [Get District]');
                //     },
                //     complete: function () {
                //         if (select2) {
                //             $(districtsSelector).select2("enable");
                //         } else {
                //             $(districtsSelector).removeAttr('disabled');
                //         }
                //     }
                // });
                return true;
            });
        },
    }
});
