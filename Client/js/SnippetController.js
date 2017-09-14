const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const URL = baseUrl + 'Server/php/snippets.php';

$(document).ready(function() {
    populateSnippetList();
});

function populateSnippetList() {
    let url = URL + '?cmd=list';
    let snippetData;
    httpGetAsync(url, function (response) {
        let formattedData = JSON.parse(/.*(\{\"status\".*$)/.exec(response)[1]);
        let snippetData = JSON.parse(formattedData['snippets']);
        for (let i = 0; i < snippetData.length; i++) {
            // Creates the snippet.
            let snippetContainer = document.createElement('div');
            snippetContainer.className = 'snippet';
            
            // Language and creator.
            let snippetHeader = document.createElement('div');
            snippetHeader.className = 'snippet-header';
            snippetHeader.innerHTML = snippetData[i].language + '<br />' + snippetData[i].creator;
            snippetContainer.appendChild(snippetHeader);
            
            let snippetDescription = document.createElement('div');
            snippetDescription.className = 'snippet-description';
            snippetDescription.innerText = snippetData[i].description;
            snippetContainer.appendChild(snippetDescription);
            
            let snippetCode = document.createElement('div');
            snippetCode.className = 'snippet-code';
            snippetCode.innerText = '/code/ /code/ /code/';
            snippetContainer.appendChild(snippetCode);
            
            //console.log(snippetData[i]);
            //console.log(snippetData[i].id);
            //console.log(snippetData[i].creator);
            //console.log(snippetData[i].description);
            //console.log(snippetData[i].language);
            
            document.getElementsByClassName('snippet-list')[0].appendChild(snippetContainer);
        }
    });
}

function httpGetAsync(theUrl, callback)
{
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            callback(xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}