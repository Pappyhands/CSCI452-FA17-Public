/* global $ SnippetsModel snippetsTable */

const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const SnippetsUrl = baseUrl + 'Server/php/snippets.php';
const model = new SnippetsModel();
$(document).ready(function() {
    window.snippetsTable = $('#snippets-table').DataTable({
        'columnDefs': [
            {
                'targets': [0],
                'visible': false,
                'searchable': false,
            }
        ],
    });
    
    $('#snippets-table tbody').on( 'click', 'tr', function () {
        model.setSelectedSnippet(snippetsTable.row(this));
        updateSnippet();
    });
    
    getSnippets();
}); 

function getSnippets() {
    let url = SnippetsUrl + '?cmd=list';
    httpGetAsync(url, function (response) {
        let formattedData = JSON.parse(response);
        let snippetData = JSON.parse(formattedData['snippets']);
        model.setSnippetsList(snippetData);
        updateView();
    });
}

// VIEW 

function updateSnippet() {
    var snippet = model.getSelectedSnippet();
    var row = model.getSnippetRow();
    $('#snippets-table tbody')
        .find('tr.selected')
        .removeClass('selected');
    $(row.node()).addClass('selected');
    var code = $('#snippet-frame')
        .find('code')
        .text(snippet.code);
}

function updateView() {
    let snippets = model.getSnippets();
    console.log(snippets);
    $.each(snippets, function(index, snippet) {
        snippetsTable.row.add([
            snippet['id'],
            snippet['creator'],
            snippet['description'],
            snippet['language']
        ]);
    });
    snippetsTable.draw();
}


// make an arbitrary ajax call to the server
function httpGetAsync(theUrl, callback) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            callback(xmlHttp.responseText);
        }
    };
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}