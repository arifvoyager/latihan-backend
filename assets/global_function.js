$( document ).ready(function() {
    console.log( "Welcome to Codeq IT Solutions" );
	console.log("For More Info : +62 898-286-060-3")
});

function set_currency(curr) {
    $.ajax({
        url: BASE_URL + 'ajax/setCurr',
        type: 'POST',
        data: {
            curr: curr
        },
        success: function (response) {
            //console.log(response);
            location.reload();
            //window.location = response;
        }
    });    
}

function set_language(lang) {
    $.ajax({
        url: BASE_URL + 'ajax/setLang',
        type: 'POST',
        data: {
            lang: lang
        },
        success: function (response) {
            console.log('meong >> '+BASE_URL);
            window.location = response;
            //location.reload();
            //$(location).attr(BASE_URL);
            //location.reload();
        }
    });    
}