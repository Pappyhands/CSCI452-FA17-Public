const URL = '/?'; // < Placeholder

$(document).ready(function() {
    populateSnippetList();
});

function populateSnippetList() {
    let url = URL + 'cmd=list';
    httpGetAsync(url, function (response) {
        for (let i = 0; i < response.length; i++) {
            console.log(response[i]);
        }
    });
}

function httpGetAsync(theUrl, callback)
{
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            callback(xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}