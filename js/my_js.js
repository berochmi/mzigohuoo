function isValidNum(val) {
    return isNaN(val.replaceAll(",", ""));
}

function inDataList(list_id, input_id) {
    let list_options = [];
    let no_of_options = list_id.options.length;
    for (var i = 0; i < no_of_options; ++i) {
        list_options.push(list_id.options[i].value);
    }
    return list_options.includes(input_id.value);
}

function checkMtInps(inps, color) {
    let chk_inps = true;

    inps.forEach(function(inp) {
        if (_(inp).value == "") {
            _(inp).style.background = color;
            chk_inps = false;
        } else {
            _(inp).style.background = 'white';
        }
    });
    return chk_inps;
}

function clearInputs(inps) {
    inps.forEach(function(inp) {
        document.getElementById(inp).value = "";
    });

}

function loadElemPost(elem_affected, url, form_data) {
    var xml_http_request = new XMLHttpRequest();
    xml_http_request.open("POST", url);
    xml_http_request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(elem_affected).innerHTML = this.responseText;
        }
    };
    xml_http_request.send(form_data);
}



function loadElemPost(elem_affected, url, form_data) {
    var xml_http_request = new XMLHttpRequest();
    xml_http_request.open("POST", url);
    xml_http_request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(elem_affected).innerHTML = this.responseText;
        }
    };
    xml_http_request.send(form_data);
}


function adedde(url, form_data, success_action, fail_action) {
    var xml_http_request = new XMLHttpRequest();
    xml_http_request.open("POST", url);
    xml_http_request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var fb_data = JSON.parse(xml_http_request.responseText);
            if (fb_data.matokeo == "success") {
                success_action(fb_data);
            } else if (fb_data.matokeo == "failed") {
                fail_action(fb_data);
            } else {
                console.log(fb_data.fb_msg);
            }
        }
    };
    xml_http_request.send(form_data);
}

function _(x) {
    return document.getElementById(x);
}
$(document).on("keyup", ".my-num", function(event) {

    let first_ind = this.value.indexOf(".");
    let last_ind = this.value.lastIndexOf(".");
    let dif_ind = last_ind - first_ind;
    let key_val = event.key;
    let allowed = ["Enter", "Backspace", "Shift", "Tab"];
    if (!allowed.includes(event.key)) {
        if (isValidNum(this.value) || dif_ind > 0) {
            this.value = this.value.replace(/[^\d,.]+/g, '');
            if (dif_ind > 0) {
                this.value = (this.value).slice(0, last_ind);
                this.value = parseFloat((this.value).replaceAll(",", "")).toLocaleString('en-US', { maximumFractionDigits: 2, maximumFractionDigits: 2 });
            }
            alert("Numbers Please");
        } else {
            if (key_val != ".") {
                this.value = parseFloat((this.value).replaceAll(",", "")).toLocaleString('en-US', { maximumFractionDigits: 2, maximumFractionDigits: 2 });
            }
        }
    }




});

$(document).on("keyup", ".my-num-only", function(e) {


    var keyCode = e.keyCode || e.which;

    //Regex to allow only Alphabets Numbers Dash Underscore and Space
    var pattern = /^(\s*[0-9]+\s*)+/g;

    //Validating the textBox value against our regex pattern.
    var isValid = pattern.test(String.fromCharCode(keyCode));
    let allowed = ["Enter", "Backspace", "Shift", "Tab", "CapsLock", " "];

    if (!allowed.includes(e.key)) {
        if (!isValid) {
            alert("Wrong Phone Number Format");

            this.value = this.value.replace((e.key).toLowerCase(), '');
        }
    }





});

//$(document).on("keyup", ".my-num", wekaComas);

function wekaComas(event) {
    let val_raw = (this.value).replaceAll(",", "");
    let first_ind = val_raw.indexOf(".");
    let last_ind = val_raw.lastIndexOf(".");
    let dif_ind = last_ind - first_ind;

    if (!isNaN(val_raw) && val_raw.length > 0 && dif_ind) {
        this.value = parseFloat(val_raw).toLocaleString('en-US', { maximumFractionDigits: 2, maximumFractionDigits: 2 });
    }

}

$(document).on("keyup", ".my-time", function(event) {
    let allowed = ["Enter", "Backspace", ":", "Shift", "Tab"];
    if (isValidNum(event.key) && !allowed.includes(event.key)) {
        this.value = this.value.replace(/[^\d:]+/g, '');
        alert("Time Please");
    }
});

function getChromeVersion() {
    var raw = navigator.userAgent.match(/Chrom(e|ium)\/([0-9]+)\./);

    return raw ? parseInt(raw[2], 10) : false;
}