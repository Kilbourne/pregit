/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

;
(function($) {

    // Use this variable to set up the common and page specific functions. If you
    // rename this variable, you will also need to rename the namespace below.
    var Sage = {
        // All pages
        'common': {
            init: function() {
                $(' .page-title.inverted').flowtype({
                    maximum: 800,
                    minFont: 27,
                    fontRatio: 7
                });
                $(window).load(function() {
                    $('img[data-lazy-src]').each(function(i, img) {
                        lazy_load_image(img);
                    });
                });

            },
            finalize: function() {
                // JavaScript to be fired on all pages, after page specific JS is fired
            }
        },
        // Home page
        'home': {
            init: function() {
                $('.brand-form-submit').click(function(event) {
                    $('#gform_submit_button_3').click();
                });

            },
            finalize: function() {
                // JavaScript to be fired on the home page, after the init JS
            }
        },
        'single_product': {
            init: function() {
                if ($('.cibo .temperatura').length) {
                    var adjustTemperaturaHeight = function() {
                        var adjusted = false;
                        if ($(window).width() >= 800) {
                            $('.temperatura .attributo-espanso-content').height(function() {
                                $(this).height('auto');
                                return $(this).parent().height() - $('.temperatura .attributo-espanso-title').height();
                            });
                            adjusted = false;
                        } else {
                            if (!adjusted) $('.temperatura .attributo-espanso-content').height('auto');
                            adjusted = true;
                        }

                    };
                    adjustTemperaturaHeight();
                    $(window).resize(adjustTemperaturaHeight);
                }

                $('.tabella-attributi .reset_variations').click(function(event) {
                    event.preventDefault();
                    $('.tabella-attributi select').val('').change();
                    $('.variations_form.cart').trigger('reset_data');
                });
                $('.tabella-attributi select').change(function(e) {
                    var val = $(this).val();
                    var id = e.target.id;
                    $('.buy-container #' + id).val(val).change();
                });
                $("form.cart").on("change", "input.qty", function() {
                    if (this.value === "0")
                        this.value = "1";

                    $(this.form).find(".single_add_to_cart_button[data-quantity]").data("quantity", this.value);
                });
                $(document.body).on("added_to_cart", function() {
                    var val = Number($('.wcmenucart-text>.cart-length').text());

                    $("a.added_to_cart").remove();
                });
            }
        },
        'um_page_account': {
            init: function() {
                (function(original) {
                    jQuery.fn.clone = function() {
                        var result = original.apply(this, arguments),
                            my_textareas = this.find('textarea').add(this.filter('textarea')),
                            result_textareas = result.find('textarea').add(result.filter('textarea')),
                            my_selects = this.find('select').add(this.filter('select')),
                            result_selects = result.find('select').add(result.filter('select'));

                        for (var i = 0, l = my_textareas.length; i < l; ++i) $(result_textareas[i]).val($(my_textareas[i]).val());
                        for (var i = 0, l = my_selects.length; i < l; ++i) {
                            for (var j = 0, m = my_selects[i].options.length; j < m; ++j) {
                                if (my_selects[i].options[j].selected === true) {
                                    result_selects[i].options[j].selected = true;
                                }
                            }
                        }
                        return result;
                    };
                })(jQuery.fn.clone);
                $('.um-account-main #gform_submit_button_6').on('click', function(event) {
                    event.preventDefault();
                    $('#gform_6 .gform_fields').replaceWith($('.um-account-main .gform_fields').clone())
                    $('#gform_6').submit();
                });
                $('#gform_6').on('submit', function(event) {
                    $('.gforms_confirmation_message').remove();
                })


                if ($('.gform_wrapper').length) {
                    $('.gfield.hidden').hide();

                    var max_rows = $('.gfield_list_group').first().find('option').length;

                    gform.addFilter('gform_list_item_pre_add', function(clone) {

                        clone.find('.datepicker').removeClass('hasDatepicker').removeAttr('id');
                        set_max_rows(clone.find('.gfield_list_icons img'));
                        return clone;
                    });

                    function set_max_rows(buttons) {

                        if (buttons) {
                            buttons.first().attr('onclick', "gformAddListItem(this, " + max_rows + ")");
                            buttons.first().attr('onkeypress', "gformAddListItem(this, " + max_rows + ")");
                            buttons.last().attr('onclick', "gformDeleteListItem(this, " + max_rows + ")");
                            buttons.last().attr('onkeypress', "gformDeleteListItem(this, " + max_rows + ")");
                        }
                    }

                    $('.gfield_list_icons').each(function(index, el) {

                        var buttons = $(el).children('img');
                        set_max_rows(buttons);
                    });

                    function disable_option() {
                        var rows = $('.um-account-tab .gfield_list_group');
                        var options = rows.find('option');
                        var selected = [];
                        var disabled = [];

                        rows.each(function(index, el) {
                            var val = $(this).find('select').val();
                            if (val) selected.push(val);
                        });

                        options.each(function(index) {
                            if ($(this).attr('disabled') === 'disabled') disabled.push($(this).val());
                        });

                        options.each(function(index, el) {
                            if (selected.indexOf($(el).val()) !== -1 && $(el).parent().val() !== $(el).val()) {
                                $(el).attr('disabled', 'disabled');
                            } else if (disabled.indexOf($(el).val()) !== -1) {
                                $(el).attr('disabled', null);
                            }
                        });
                    }

                    disable_option();

                    $('.ginput_list').on('click', '.gfield_list_icons img', function(event) { disable_option(); });
                    $('.ginput_list').on('focus', '.datepicker', function(e) { gformInitDatepicker(); })
                    $('.ginput_list').on('change focus mousedown keydown touchstart', '.gfield_list_group select', function(event) { disable_option(); });
                }
            }
        },
        // About us page, note the change from about-us to about_us.
        'about_us': {
            init: function() {
                // JavaScript to be fired on the about us page
            }
        }
    };

    // The routing fires all common scripts, followed by the page specific scripts.
    // Add additional events for more control over timing e.g. a finalize event
    var UTIL = {
        fire: function(func, funcname, args) {
            var fire;
            var namespace = Sage;
            funcname = (funcname === undefined) ? 'init' : funcname;
            fire = func !== '';
            fire = fire && namespace[func];
            fire = fire && typeof namespace[func][funcname] === 'function';

            if (fire) {
                namespace[func][funcname](args);
            }
        },
        loadEvents: function() {
            // Fire common init JS
            UTIL.fire('common');

            // Fire page-specific init JS, and then finalize JS
            $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
                UTIL.fire(classnm);
                UTIL.fire(classnm, 'finalize');
            });

            // Fire common finalize JS
            UTIL.fire('common', 'finalize');
        }
    };

    // Load Events
    $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
