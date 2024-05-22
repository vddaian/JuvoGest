function changeNavState() {
    if ($('#nav').attr('hidden')) {
        $('#nav').prop("hidden", false);
    } else {
        $('#nav').prop("hidden", true);
    }
}

function changeUserNavState() {
    if ($('#userNav').attr('hidden')) {
        $('#userNav').prop("hidden", false);
    } else {
        $('#userNav').prop("hidden", true);
    }
}

function charge() {
    $('#bar1').prop("hidden", false);
    $('#bar2').prop("hidden", false);
}