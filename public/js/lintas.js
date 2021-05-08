var Lintas = function () { }
if (!window.lintas) {
    window.lintas = new Lintas();
}

(function ($, window, document, undefined) {
    $.lintas = {
        _filesadded: "",
        menu: function() {
            var url = window.location;
            $('ul li.has-sub a').filter(function() {
                return this.href == url;
            }).parentsUntil(".nav").addClass('active');

            $('ul li a').filter(function() {
                return this.href == url;
            }).parentsUntil(".nav").addClass('active');
        },
        file_upload: function() {
            $('.inputfile').each(function(){
                var $input = $( this ),
                    $label = $input.next( 'label' ),
                    labelVal = $label.html();
                $input.on( 'change', function( e )
                {
                    var fileName = '';
                    if( this.files && this.files.length > 1 )
                        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                    else if( e.target.value )
                        fileName = e.target.value.split( '\\' ).pop();

                    if( fileName )
                        $label.find( 'span' ).html( fileName );
                    else
                        $label.html( labelVal );
                });

                // Firefox bug fix
                $input
                .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
                .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
            });  
        },
        message: function (type, message, alert_type, callback) {
            alert_type = typeof alert_type !== 'undefined' ? alert_type : 'notify';
            var container = $('.content');
            if (alert_type == 'bootbox') {
                if (typeof callback == 'undefined') {
                    bootbox.alert(message);
                } else {
                    bootbox.alert(message, callback);
                }
            }

            if (alert_type == 'notify') {
                obj = $('<div>');
                container.prepend(obj);
                obj.addClass('notifications');
                obj.addClass('top-right');
                obj.notify({
                    'message': {text: message},
                    'type': type
                }).show();
            }

            if(alert_type == 'modal') {
                obj = $('<div>');
                $(".modal-lnj .modal-body").prepend(obj);
                obj.addClass('notifications');
                obj.addClass('top-right');
                obj.notify({
                    'message': {text: message},
                    'type': type
                }).show();
            }
        },
        _loadjscss: function (filename, filetype, callback) {
            if (filetype == "js") { //if filename is a external JavaScript file
                var fileref = document.createElement('script')
                fileref.setAttribute("type", "text/javascript")
                fileref.setAttribute("src", filename)
            } else if (filetype == "css") { //if filename is an external CSS file
                var fileref = document.createElement("link")
                fileref.setAttribute("rel", "stylesheet")
                fileref.setAttribute("type", "text/css")
                fileref.setAttribute("href", filename)
            }
            if (typeof fileref != "undefined") {
                fileref.onload = $.lintas._handle_response_callback(callback);
                if (typeof (callback) === 'function') {
                    fileref.onreadystatechange = function () {
                        if (this.readyState == 'complete') {
                            $.lintas._handle_response_callback(callback);
                        }
                    }
                }
                document.getElementsByTagName("head")[0].appendChild(fileref);
            }
        },
        _removejscss: function (filename, filetype) {
            var targetelement = (filetype == "js") ? "script" : (filetype == "css") ? "link" : "none"; //determine element type to create nodelist from
            var targetattr = (filetype == "js") ? "src" : (filetype == "css") ? "href" : "none"; //determine corresponding attribute to test for
            var allsuspects = document.getElementsByTagName(targetelement);
            for (var i = allsuspects.length; i >= 0; i--) { //search backwards within nodelist for matching elements to remove
                if (allsuspects[i] && allsuspects[i].getAttribute(targetattr) != null && allsuspects[i].getAttribute(targetattr).indexOf(filename) != -1) {
                    allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
                }
            }
        },
        _handle_response: function (data, callback) {
            if (data.css_require && data.css_require.length > 0) {
                for (var i = 0; i < data.css_require.length; i++) {
                    $.lintas.require(data.css_require[i], 'css');
                }
            }
            require(data.js_require, callback); 
            $.lintas._filesloaded = 0;
            $.lintas._filesneeded = 0;
            if (data.css_require && data.css_require.length > 0)
                $.lintas._filesneeded += data.css_require.length;
            if (data.js_require && data.js_require.length > 0)
                $.lintas._filesneeded += data.js_require.length;
            if (data.css_require && data.css_require.length > 0) {
                for (var i = 0; i < data.css_require.length; i++) {
                    $.lintas.require(data.css_require[i], 'css', callback);
                }
            }
            if (data.js_require && data.js_require.length > 0) {
                for (var i = 0; i < data.js_require.length; i++) {
                    $.lintas.require(data.js_require[i], 'js', callback);
                }
            }
            if ($.lintas._filesloaded == $.lintas._filesneeded) {
                callback();
            }
        },
        _handle_response_callback: function (callback) {
            $.lintas._filesloaded++;
            if ($.lintas._filesloaded == $.lintas._filesneeded) {
                callback();
            }
        },
        require: function (filename, filetype, callback) {
            if ($.lintas._filesadded.indexOf("[" + filename + "]") == -1) {
                $.lintas._loadjscss(filename, filetype, callback);
                $.lintas._filesadded += "[" + filename + "]" //List of files added in the form "[filename1],[filename2],etc"
            } else {
                $.lintas._filesloaded++;
                if ($.lintas._filesloaded == $.lintas._filesneeded) {
                    callback();
                }
            }
            return;
        },
        fullscreen: function (element) {
            if (!$('body').hasClass("full-screen")) {
                $('body').addClass("full-screen");
                if (element.requestFullscreen) {
                    element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                    element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                    element.webkitRequestFullscreen();
                } else if (element.msRequestFullscreen) {
                    element.msRequestFullscreen();
                }
            } else {
                $('body').removeClass("full-screen");
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        },
        replace_all: function (string, find, replace) {
            escaped_find = find.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
            return string.replace(new RegExp(escaped_find, 'g'), replace);
        },
        thousand_separator: function (rp) {
            rp = "" + rp;
            var rupiah = "";
            var vfloat = "";

            var ds = window.lintas.decimal_separator;
            var ts = window.lintas.thousand_separator;
            var dd = window.lintas.decimal_digit;
            var dd = parseInt(dd);
            var minus_str = "";

            if (rp.indexOf("-") >= 0) {
                minus_str = rp.substring(rp.indexOf("-"), 1);
                rp = rp.substring(rp.indexOf("-") + 1);
            }

            if (rp.indexOf(".") >= 0) {
                vfloat = rp.substring(rp.indexOf("."));
                rp = rp.substring(0, rp.indexOf("."));
            }

            p = rp.length;

            while (p > 3) {
                rupiah = ts + rp.substring(p - 3) + rupiah;
                l = rp.length - 3;
                rp = rp.substring(0, l);
                p = rp.length;
            }

            rupiah = rp + rupiah;
            vfloat = vfloat.replace('.', ds);
            if (vfloat.length > dd)
                vfloat = vfloat.substring(0, dd + 1);
            return minus_str + rupiah + vfloat;
        },
        format_currency: function (rp) {
            return $.lintas.thousand_separator(rp);
        },
        unformat_currency: function (rp) {
            if (typeof rp == "undefined") {
                rp = '';
            }

            var ds = window.lintas.decimal_separator;
            var ts = window.lintas.thousand_separator;
            var last3 = rp.substr(rp.length - 3);
            var char_last3 = last3.charAt(0);
            if (char_last3 != ts) {
                rp = this.replace_all(rp, ts, '');
            }
            
            rp = rp.replace(ds, ".");
            return rp;
        },
        
    }
    
    
    String.prototype.format_currency = function () {
        return $.lintas.format_currency(this)
    };

    String.prototype.unformat_currency = function () {
        return $.lintas.unformat_currency(this);
    };
})(this.jQuery, window, document);
