$(document).ready(function() {
    //Selectors
    const btn_add = _("add");

    //Event Listeners
    btn_add.addEventListener("click", addUser);
    $(document).on("click", ".btn-edit", editProductOut);
    $(document).on("click", ".btn-dele", deleProductOut);



    //Functions
    function addUser(event) {
        event.preventDefault();
        let url = '/errandzangu/users/addUserAjax';

        let form_data = new FormData();
        let inps_required = ["fname", "lname", "username", "role"];
        if (checkMtInps(inps_required, 'pink')) {
            if (confirm("Do You Want Complete This Action?")) {
                let post_ids = ["fname", "lname", "username", "role", "mname", "staff_id", 'csrf_token'];
                post_ids.forEach(function(post_id) {
                    form_data.append(post_id, document.getElementById(post_id).value);
                });
                let success_action = function(fb_data) {
                    clearInputs(["fname", "lname", "username", "role", "mname", "staff_id"]);
                    fb_msg.innerHTML = fb_data.fb_msg;
                    loadUser3(fb_data.user_id);
                }
                let fail_action = function(fb_data) {
                    fb_msg.innerHTML = fb_data.fb_msg;
                }
                fb_msg.innerHTML = '<p class="alert alert-info font-weight-bold">Please Wait...</p>';
                adedde(url, form_data, success_action, fail_action);

            }
        }

    }

    function loadUser3(user_id) {
        let elem_affected = "rs_user";
        let url = '/errandzangu/users/loadUser3Ajax';
        let form_data = new FormData();
        form_data.append("user_id", user_id);
        loadElemPost(elem_affected, url, form_data);
    }

    function editProductOut(event) {
        event.preventDefault();
        let products_outs_id = this.id.replaceAll("edit", "");
        let url = '/errandzangu/productsOuts/editProductOutAjax';
        let form_data = new FormData();
        let inps_required = ["product_qty_out" + products_outs_id];
        if (checkMtInps(inps_required, 'pink')) {

            if (confirm("Do You Want To Edit This Dispatched Product?")) {
                let post_ids = ['csrf_token'];
                post_ids.forEach(function(post_id) {
                    form_data.append(post_id, document.getElementById(post_id).value);
                });
                form_data.append("product_qty_out", document.getElementById("product_qty_out" + products_outs_id).value);
                form_data.append("products_outs_id", products_outs_id);
                let success_action = function(fb_data) {
                    fb_msg.innerHTML = fb_data.fb_msg;
                    product_stock_level.value = fb_data.product_stock_level;

                }
                let fail_action = function(fb_data) {
                    fb_msg.innerHTML = fb_data.fb_msg;
                    document.getElementById("product_qty_out" + products_outs_id).value = fb_data.old_qty;
                }
                fb_msg.innerHTML = '<p class="alert alert-info font-weight-bold">Please Wait...</p>';
                adedde(url, form_data, success_action, fail_action);

            }
        }

    }

    function deleProductOut(event) {
        event.preventDefault();
        let products_outs_id = this.id.replaceAll("dele", "");
        let url = '/errandzangu/productsOuts/deleProductOutAjax';
        let form_data = new FormData();
        let inps_required = ["product_qty_out" + products_outs_id];
        if (checkMtInps(inps_required, 'pink')) {

            if (confirm("Do You Want To Delete This Dispatched Product?")) {
                let post_ids = ['csrf_token'];
                post_ids.forEach(function(post_id) {
                    form_data.append(post_id, document.getElementById(post_id).value);
                });
                form_data.append("product_qty_out", document.getElementById("product_qty_out" + products_outs_id).value);
                form_data.append("products_outs_id", products_outs_id);
                let success_action = function(fb_data) {
                    fb_msg.innerHTML = fb_data.fb_msg;
                    product_stock_level.value = fb_data.product_stock_level;
                    rs_product_out.innerHTML = "";

                }
                let fail_action = function(fb_data) {
                    fb_msg.innerHTML = fb_data.fb_msg;
                    document.getElementById("product_qty_out" + products_outs_id).value = fb_data.old_qty;
                }
                fb_msg.innerHTML = '<p class="alert alert-info font-weight-bold">Please Wait...</p>';
                adedde(url, form_data, success_action, fail_action);

            }
        }

    }


});