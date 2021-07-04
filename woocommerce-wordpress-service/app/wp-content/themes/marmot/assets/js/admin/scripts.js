(function ($) {
    'use strict';

    var Marmot = {

        translate: [],

        init: function () {
            Marmot.translate = MarmotData.translate;
            Marmot.initHqtButtons();
            Marmot.initThemeTemplatesButtons();
            Marmot.animateScroll();
        },
        // Templates page buttoms
        initThemeTemplatesButtons: function () {
            // Install / Activate plugins
            $('[data-hqt-btn="setup-template"]').each(function (i, el) {
                var $button = $(this);

                $button.on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);

                    if ($this.data('hqt-template-option').length) {
                        var $button = $this;
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'hq_setup_template',
                                template_option: $button.data('hqt-template-option'),
                                template_name: $button.data('hqt-template-name'),
                                _ajax_nonce: hqlibData._ajax_nonce
                            },
                            beforeSend: function (xhr) {
                                $button.addClass('loading')
                            }
                        }).fail(function (jqXHR) {
                            $button.removeClass('loading')
                            alert('Template setup failed. Please try again later.')
                        }).done(function (result) {
                            $button.removeClass('loading')
                            if (undefined !== result.data.template_id) {
                                $button.closest('div').parent().find('div').toggleClass('hidden')
                                // Update buttons
                                let url = 'http://hqtheme.el/wp-admin/post.php?post=' + result.data.template_id + '&action=elementor'
                                $button.closest('div').parent().find('[data-hqt-btn="setup-template-edit-template"]').attr('href', url)
                            } else {
                                alert('Template setup failed. Please try again later.')
                            }
                        });
                    }
                });

                // Wrap button text in span tag
                if (!$button.find('.btn-label').length) {
                    $button.wrapInner('<span class="btn-label"></div>');
                }
                $button.append('<span class="hqt-btn-ellipsis"><span></span><span></span><span></span><span></span></span>');
            });

            // Set no template
            $('[data-hqt-btn="disable-template"]').each(function (i, el) {
                var $button = $(this);

                $button.on('click', function (e) {
                    e.preventDefault();
                    var $this = $(this);

                    if ($this.data('hqt-template-option').length) {
                        var $button = $this;
                        $.ajax({
                            url: ajaxurl,
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                action: 'hq_setup_template',
                                template_option: $button.data('hqt-template-option'),
                                template_name: $button.data('hqt-template-name'),
                                set_noeltmp: 1,
                                _ajax_nonce: hqlibData._ajax_nonce
                            },
                            beforeSend: function (xhr) {
                                $button.addClass('loading')
                            }
                        }).fail(function (jqXHR) {
                            $button.removeClass('loading')
                            alert('Template setup failed. Please try again later.')
                        }).done(function (result) {
                            $button.removeClass('loading')
                            $button.closest('div').parent().find('div').toggleClass('hidden')
                            // Update buttons
                            $button.closest('div').parent().find('[data-hqt-btn="setup-template-edit-template"]').parent().remove();
                        });
                    }
                });

                // Wrap button text in span tag
                if (!$button.find('.btn-label').length) {
                    $button.wrapInner('<span class="btn-label"></div>');
                }
                $button.append('<span class="hqt-btn-ellipsis"><span></span><span></span><span></span><span></span></span>');
            });
        },
        // HQ Tabs
        initHqtButtons: function () {
            // Install / Activate plugins
            $('[data-hqt-btn="install-activate-plugin"]').each(function (i, el) {
                var $button = $(this);

                // Change button text
                if ($button.data('action-label').length) {
                    var label = $button.html(), action;

                    if ($button.data('install-url').length) {
                        action = Marmot._('install');
                    } else {
                        action = Marmot._('activate');
                    }
                    switch ($button.data('action-label')) {
                        case 'prepend':
                            $button.html(action + ' ' + label);
                            break;
                        case 'replace':
                            $button.html(action);
                            break;
                    }
                }
                // Wrap button text in span tag
                if (!$button.find('.btn-label').length) {
                    $button.wrapInner('<span class="btn-label"></div>');
                }

                // Bind button click event
                Marmot.bindButtonClick($button);

                // Bind show/hide button loader
                $button.on('loader/show', function () {
                    $(this).off('click');
                    $(this).addClass('loading');
                });
                $button.on('loader/hide', function () {
                    Marmot.bindButtonClick($(this));
                    $(this).removeClass('loading');
                });
            });
        },
        bindButtonClick: function (button) {
            var $button = $(button);
            // Append some html for ajax spinner
            if (!$button.find('.hqt-btn-ellipsis').length) {
                $button.append('<span class="hqt-btn-ellipsis"><span></span><span></span><span></span><span></span></span>');
            }

            $button.on('click', function (e) {
                e.preventDefault();
                var $this = $(this);

                if ($this.data('install-url').length) {
                    // Install if plugin is missing
                    Marmot.installPluginByBtn($this);
                } else {
                    // Activate if plugin is installed
                    Marmot.activatePluginByBtn($this);
                }
            });
        },
        installPluginByBtn: function (button) {
            var $button = $(button);
            if (!$button.data('install-url').length) {
                return false;
            }
            $.ajax({
                url: $button.data('install-url'),
                type: 'GET',
                beforeSend: function (xhr) {
                    $button.data('install-url', '')
                    $button.trigger('loader/show')
                }
            }).fail(function (jqXHR) {
                $button.trigger('loader/hide')
                alert('Plugin installation fail. Please try again.')
            }).done(function (result) {
                $button.trigger('loader/hide')
                $button.find('.btn-label').html(Marmot._('activate'))
                Marmot.bindButtonClick($button)
            });
        },
        activatePluginByBtn: function (button) {
            var $button = $(button);
            if (!$button.data('activate-url').length) {
                return false;
            }
            $.ajax({
                url: $button.data('activate-url'),
                type: 'GET',
                beforeSend: function (xhr) {
                    $button.trigger('loader/show')
                }
            }).fail(function (jqXHR) {
                $button.trigger('loader/hide')
                alert('Plugin activation fail. Please try again.');
            }).done(function (result) {
                $button.trigger('loader/hide')
                Marmot.buttonCallbackAction($button);
            });
        },
        buttonCallbackAction: function (button) {
            var $button = $(button);
            if (!$button.data('callback').length) {
                return false;
            }
            switch ($button.data('callback')) {
                case 'refresh-page':
                    location.reload();
                    break;
                case 'replace-button-label-activated':
                    $button.replaceWith(Marmot._('activated'));
                    break;
            }
        },
        animateScroll: function () {
            // Internal links - smooth scroll
            $('a[href*="#"]:not([href="#"]):not(.hq-noscroll):not(.wc-tabs a)').click(function () {
                if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                    if (target.length) {
                        // http://api.jquery.com/animate/
                        $('html, body').animate({
                            scrollTop: target.offset().top - 50
                        }, 500);
                        return false;
                    }
                }
            });

            // Use empty links in menu - prevent scroll to top
            $('a[href="#"]').click(function (e) {
                e.preventDefault();
            });
        },
        _: function (key) {
            if (Marmot.translate[key].length) {
                return Marmot.translate[key];
            }
            return false;
        }
    }

    $(document).ready(function () {
        Marmot.init();
    });
})(jQuery);