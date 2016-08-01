function hideAlert() {
    $("#msg_alert").html('');
}

function showAlert(msg) {
    $('html, body').animate({scrollTop: 0}, 400);
    $("#msg_alert").html(msg);
    setTimeout(hideAlert, 2000);
}

function getCurrentYear() {
    var today = new Date();
    var dd = today.getDate();
    var yyyy = today.getFullYear();
    return yyyy;
}

function getCurrentMonth() {
    var today = new Date();
    var mm = today.getMonth() + 1;//January is 0!`
    return mm;
}

function lpad(value){
    var str = "" + value;
    var pad = "00";
    var ans = pad.substring(0, pad.length - str.length) + str;
    return ans;
}

