/* global $ model snippetsTable Prism */

const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const URL = baseUrl + 'Server/php/snippets.php';

$(document).ready(function() {
    window.snippetsTable = $('#snippets-table').DataTable({
        'columnDefs': [
            {
                'targets': [ 0 ],
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
    let url = URL + '?cmd=list';
    httpGetAsync(url, function (response) {
        let formattedData = JSON.parse(/.*(\{\"status\".*$)/.exec(response)[1]);
        let snippetData = JSON.parse(formattedData['snippets']);
        model.updateSnippetsList(snippetData);
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
        .removeClass()
        .addClass('language-' + snippet.language.toLowerCase()) // not sure if this works for all languages
        .text(snippet.code);
    Prism.highlightElement(code.get(0));
}

function updateView() {
    let snippets = model.getSnippets();
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