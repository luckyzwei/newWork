$(function () {
    $("[name='tips']").fadeOut(3000);
    /**启动 iCheck**/
    $('.select-messages input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });

    $(".checkbox-toggle").on('ifChecked', function () {
        $(".select-messages input[type='checkbox']").iCheck("check");
    });
    $(".checkbox-toggle").on('ifUnchecked', function () {
        $(".select-messages input[type='checkbox']").iCheck("uncheck");
    });

});


//给定url参数名 获取参数值
function getURLVar(key) {
    var value = [];

    var query = String(document.location).split('?');

    if (query[1]) {
        var part = query[1].split('&');

        for (i = 0; i < part.length; i++) {
            var data = part[i].split('=');

            if (data[0] && data[1]) {
                value[data[0]] = data[1];
            }
        }

        if (value[key]) {
            return value[key];
        } else {
            return '';
        }
    }
}


// Tooltip remove fixed
$(document).on('click', '[data-toggle=\'tooltip\']', function (e) {
    $('body > .tooltip').remove();
});




// Image Manager
$(document).on('click', 'a[data-toggle=\'image\']', function (e) {
    var $element = $(this);
    var $popover = $element.data('bs.popover'); // element has bs popover?

    e.preventDefault();

    // destroy all image popovers
    $('a[data-toggle="image"]').popover('destroy');

    // remove flickering (do not re-add popover when clicking for removal)
    if ($popover) {
        return;
    }

    $element.popover({
        html: true,
        placement: 'right',
        trigger: 'manual',
        content: function () {
            return '<button type="button" id="button-image" class="btn btn-primary"><i class="fa fa-pencil"></i></button> <button type="button" id="button-clear" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>';
        }
    });

    $element.popover('show');

    $('#button-image').on('click', function () {
        var $button = $(this);
        var $icon = $button.find('> i');

        $('#modal-image').remove();

        if (Cookies.get('imagemanager_last_open_folder') && (Cookies.get('imagemanager_last_open_folder') != 'undefined')) {
            imagemanager_last_open_folder = Cookies.get('imagemanager_last_open_folder');
        } else {
            imagemanager_last_open_folder = '';
        }

        $.ajax({
            url: '/FileManager/index.html?directory=' + imagemanager_last_open_folder + '&target=' + $element.parent().find('input').attr('id') + '&thumb=' + $element.attr('id'),
            dataType: 'html',
            beforeSend: function () {
                $button.prop('disabled', true);
                if ($icon.length) {
                    $icon.attr('class', 'fa fa-circle-o-notch fa-spin');
                }
            },
            complete: function () {
                $button.prop('disabled', false);
                if ($icon.length) {
                    $icon.attr('class', 'fa fa-pencil');
                }
            },
            success: function (html) {
                $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                $('#modal-image').modal('show');
            }
        });

        $element.popover('destroy');
    });

    $('#button-clear').on('click', function () {
        if ($element.find('img').attr("name") === "imgProductShow") {
            $element.popover('destroy');
            $element.find('img').parent().remove();
        } else {
            $element.find('img').attr('src', $element.find('img').attr('data-placeholder'));
            $element.parent().find('input').val('');
        }

        $element.popover('destroy');
    });
});

// Autocomplete */
(function ($) {
    $.fn.autocomplete = function (option) {
        return this.each(function () {
            var $this = $(this);
            var $dropdown = $('<ul class="dropdown-menu" />');

            this.timer = null;
            this.items = [];

            $.extend(this, option);

            $this.attr('autocomplete', 'off');

            // Focus
            $this.on('focus', function () {
                this.request();
            });

            // Blur
            $this.on('blur', function () {
                setTimeout(function (object) {
                    object.hide();
                }, 200, this);
            });

            // Keydown
            $this.on('keydown', function (event) {
                switch (event.keyCode) {
                    case 27: // escape
                        this.hide();
                        break;
                    default:
                        this.request();
                        break;
                }
            });

            // Click
            this.click = function (event) {
                event.preventDefault();

                var value = $(event.target).parent().attr('data-value');

                if (value && this.items[value]) {
                    this.select(this.items[value]);
                }
            }

            // Show
            this.show = function () {
                var pos = $this.position();

                $dropdown.css({
                    top: pos.top + $this.outerHeight(),
                    left: pos.left
                });

                $dropdown.show();
            }

            // Hide
            this.hide = function () {
                $dropdown.hide();
            }

            // Request
            this.request = function () {
                clearTimeout(this.timer);

                this.timer = setTimeout(function (object) {
                    object.source($(object).val(), $.proxy(object.response, object));
                }, 200, this);
            }

            // Response
            this.response = function (json) {
                var html = '';
                var category = {};
                var name;
                var i = 0, j = 0;

                if (json.length) {
                    for (i = 0; i < json.length; i++) {
                        // update element items
                        this.items[json[i]['value']] = json[i];

                        if (!json[i]['category']) {
                            // ungrouped items
                            html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
                        } else {
                            // grouped items
                            name = json[i]['category'];
                            if (!category[name]) {
                                category[name] = [];
                            }

                            category[name].push(json[i]);
                        }
                    }

                    for (name in category) {
                        html += '<li class="dropdown-header">' + name + '</li>';

                        for (j = 0; j < category[name].length; j++) {
                            html += '<li data-value="' + category[name][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[name][j]['label'] + '</a></li>';
                        }
                    }
                }

                if (html) {
                    this.show();
                } else {
                    this.hide();
                }

                $dropdown.html(html);
            }

            $dropdown.on('click', '> li > a', $.proxy(this.click, this));
            $this.after($dropdown);
        });
    };

})(window.jQuery);








