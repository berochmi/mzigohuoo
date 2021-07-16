//Const
const clv_sender_contacts = new Cleave('#sender_contacts', {
    delimiters: [' '],
    blocks: [4, 6]

});
const clv_receiver_contacts = new Cleave('#receiver_contacts', {
    delimiters: [' '],
    blocks: [4, 6]

});
const clv_collected_by_contacts = new Cleave('#collected_by_contacts', {
    delimiters: [' '],
    blocks: [4, 6]

});
const clv_package_qty = new Cleave('#package_qty', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
const clv_package_amount_paid = new Cleave('#package_amount_paid', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
const clv_received_package_qty = new Cleave('#received_package_qty', {
    numeral: true,
    numeralThousandsGroupStyle: 'thousand'
});
let clv_time_received = new Cleave('#time_received', {
    time: true,
    timePattern: ['h', 'm']
});
let clv_collection_time = new Cleave('#collection_time', {
    time: true,
    timePattern: ['h', 'm']
});
let clv_received_time = new Cleave('#received_time', {
    time: true,
    timePattern: ['h', 'm']
});
let clv_received_collection_time = new Cleave('#received_collection_time', {
    time: true,
    timePattern: ['h', 'm']
});
let clv_collected_time = new Cleave('#collected_time', {
    time: true,
    timePattern: ['h', 'm']
});
const date_received = _("date_received");
const time_received = _("time_received");
const collection_date = _("collection_date");
const collection_time = _("collection_time");
const received_date = _("received_date");
const received_time = _("received_time");
const received_collection_date = _("received_collection_date");
const received_collection_time = _("received_collection_time");

const collected_date = _("collected_date");
const collected_time = _("collected_time");
const sending_package_status = _("sending_package_status");
const send_sms = _("send_sms");
//Events

$('#date_received').datepicker({ endDate: new Date(), autoclose: true, todayHighlight: true });
$('#time_received').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });
$('#collection_date').datepicker({ endDate: new Date(), autoclose: true, todayHighlight: true });
$('#collection_time').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });
$('#received_date').datepicker({ endDate: new Date(), autoclose: true, todayHighlight: true });
$('#received_time').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });
$('#received_collection_date').datepicker({ endDate: new Date(), autoclose: true, todayHighlight: true });
$('#received_collection_time').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });

$('#collected_date').datepicker({ endDate: new Date(), autoclose: true, todayHighlight: true });
$('#collected_time').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });
$(document).on("change", "#city_to", loadBranchesTo);
$(document).on("submit", "form", checkInputs);
$(document).on("click", "#collect_package", collectPackage);

//Functions
function loadBranchesTo() {
    let elem_affected = "rs_branches_to";
    let url = '/mzigohuoo/SalesCounter/loadBranchesToAjax';
    let form_data = new FormData();
    let post_ids = ["city_to", 'csrf_token'];
    post_ids.forEach(function(post_id) {
        form_data.append(post_id, document.getElementById(post_id).value);
    });
    loadElemPost(elem_affected, url, form_data);

}

function checkInputs(e) {
    let inps_required = ["to_branch_id", "sender_name", "sender_contacts", "package_description", "package_qty",
        "package_amount_paid", "date_received", "time_received", "receiver_name", "receiver_contacts", "collection_date", "collection_time",
        "received_date", "received_time", "received_package_description", "received_package_qty", "received_collection_date", "received_collection_time",
        "collected_date", "collected_time", "collected_by_name", "collected_by_contacts", "collected_by_idno", "collected_by_id_type"
    ];
    if (checkMtInps(inps_required, 'pink') == false) {
        e.preventDefault();

    } else if (date_received.value.length > 0 && received_date.value.length > 0) {
        let mt_collected_date_time = moment(collected_date.value + ' ' + collected_time.value);
        let mt_received_date_time = moment(received_date.value + ' ' + received_time.value);
        let diff_day_time = mt_collected_date_time.diff(mt_received_date_time);
        if (diff_day_time <= 0) {
            e.preventDefault();
            bootbox.alert("<p class='alert alert-danger text-center font-weight-bold'>Check Collected and Receiving Date & Time!</p>");
        }
    }
}

function collectPackage(e) {
    e.preventDefault();
    let inps_required = ["collected_date", "collected_time", "collected_by_name", "collected_by_contacts", "collected_by_idno", "collected_by_id_type"];
    if (checkMtInps(inps_required, 'pink')) {
        let url = '/mzigohuoo/SalesCounter/collectPackageAjax';
        let form_data = new FormData();
        let post_ids = ["collected_date", "collected_time", "collected_by_name", "collected_by_contacts", "collected_by_idno", "collected_by_id_type", "sending_package_id", "csrf_token"];
        post_ids.forEach(function(post_id) {
            form_data.append(post_id, document.getElementById(post_id).value);
        });
        let success_action = function(fb_data) {
            fb_msg.innerHTML = fb_data.fb_msg;
            send_sms.disabled = false;
            sending_package_status.value = "COLLECTED";
        };
        let fail_action = function(fb_data) {
            fb_msg.innerHTML = fb_data.fb_msg;
        };
        fb_msg.innerHTML = '<p class="alert alert-info font-weight-bold">Please Wait...</p>';
        adedde(url, form_data, success_action, fail_action);
    }
}