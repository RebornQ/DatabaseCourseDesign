var script=document.createElement("script");
script.type="text/javascript";
script.src="assets/js/js_msgbox/jquery.msgBox.js";
document.body.appendChild(script);
msgBoxImagePath = "/assets/i/img_msgbox/";

function showErrorBox(content, callback) {
    $.msgBox({
        title: "警告",
        content: content,
        type: "error",
        buttons: [{value: "OK"}],
        success: function (result) {
            if (result === "OK") {
                if (typeof (callback) === 'function') {
                    callback();
                }
                return true;
            }else return false;
        }
    });
    // $.MsgBox.Confirm("温馨提示", content, function () {
    //     history.back();
    // });
}

function showInfoBox(content, callback) {
    $.msgBox({
        title: "提示",
        content: content,
        type: "info",
        buttons: [{value: "OK"}],
        success: function (result) {
            if (result === "OK") {
                if (typeof (callback) === 'function') {
                    callback();
                }
            }
        }
    });
}