GB_showCenter = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 480,
        width: width || 880,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}

GB_showForm = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 700,
        width: width || 650,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}
GB_showCentera = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 640,
        width: width || 800,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}
GB_showCenterb = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 640,
        width: width || 770,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}

GB_showAd = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 812,
        width: width || 600,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}

GB_showBvideos = function(caption, url, /* optional */ height, width, callback_fn) {
    var options = {
        caption: caption,
        center_win: true,
        height: height || 500,
        width: width || 650,
        fullscreen: false,
        callback_fn: callback_fn
    }
    var win = new GB_Window(options);
    return win.show(url);
}