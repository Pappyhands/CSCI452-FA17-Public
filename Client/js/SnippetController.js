/* 
    global $ 
    global model
    global snippetsTable
*/
const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const URL = baseUrl + 'Server/php/snippets.php';

$(document).on('ready', function() {
    window.snippetsTable = $('#snippets-table').DataTable({
        "bLengthChange" : false, //thought this line could hide the LengthMenu
    });
    getSnippets();
}); 

function getSnippets() {
    let url = URL + '?cmd=list';
    httpGetAsync(url, function (response) {
        let formattedData = JSON.parse(/.*(\{\"status\".*$)/.exec(response)[1]);
        let snippetData = JSON.parse(formattedData['snippets']);
        model.updateSnippetsList(snippetData);
        updateView();
    });
}


function updateView() {
    let snippets = model.getSnippets();
    $.each(snippets, function(index, snippet) {
        snippetsTable.row.add([
            snippet['creator'],
            snippet['description'],
            snippet['language']
        ])
    });
    snippetsTable.draw();
}

function httpGetAsync(theUrl, callback) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            callback(xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}