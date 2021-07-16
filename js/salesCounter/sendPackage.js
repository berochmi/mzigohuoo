//Const
const clv_sender_contacts = new Cleave('#sender_contacts', {
    delimiters: [' '],
    blocks: [4, 6]

});
const clv_receiver_contacts = new Cleave('#receiver_contacts', {
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
let clv_time_received = new Cleave('#time_received', {
    time: true,
    timePattern: ['h', 'm']
});
let clv_collection_time = new Cleave('#collection_time', {
    time: true,
    timePattern: ['h', 'm']
});
const date_received = _("date_received");
const time_received = _("time_received");
const collection_date = _("collection_date");
const collection_time = _("collection_time");
//Events
//$(loadBranchesTo);
$('#date_received').datepicker({ endDate: new Date(), autoclose: true, todayHighlight: true });
$('#time_received').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });
$('#collection_date').datepicker({ startDate: new Date(), autoclose: true, todayHighlight: true });
$('#collection_time').timepicker({ timeFormat: 'HH:mm', interval: 1, dropdown: false });
$(document).on("change", "#city_to", loadBranchesTo);
$(document).on("submit", "form", checkInputs);

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
        "package_amount_paid", "date_received", "time_received", "receiver_name", "receiver_contacts", "collection_date", "collection_time"
    ];
    if (checkMtInps(inps_required, 'pink') == false) {
        e.preventDefault();

    } else if (date_received.value.length > 0 && collection_date.value.length > 0) {
        let mt_received_date_time = moment(date_received.value + ' ' + time_received.value);
        let mt_collection_date_time = moment(collection_date.value + ' ' + collection_time.value);
        let diff_day_time = mt_collection_date_time.diff(mt_received_date_time);
        if (diff_day_time <= 0) {
            e.preventDefault();
            bootbox.alert("<p class='alert alert-danger text-center font-weight-bold'>Check Receiving and Collection Date & Time!</p>");
        }
    }
}