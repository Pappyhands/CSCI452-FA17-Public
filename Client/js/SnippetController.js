const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const URL = baseUrl + 'Server/php/snippets.php';

$(document).ready(function() {
    populateSnippetList();
});

let snippetData;

let switch1 = document.getElementById('switch1');
let switch2 = document.getElementById('switch2');
let switch3 = document.getElementById('switch3');
let switch4 = document.getElementById('switch4');

switch1.onmouseup = sortCreator;
switch2.onmouseup = sortDescription;
switch3.onmouseup = sortLanguage;

let sortedCreator = false;
function sortCreator() 
{
    let sortAlgorithm;
    if (sortedCreator)
    {
        sortAlgorithm = function (a, b) 
        {
            return a.creator > b.creator;
        };
    } 
    else 
    {
        sortAlgorithm = function (a, b) 
        {
            return a.creator < b.creator;
        };
    }
    snippetData.sort(sortAlgorithm);
    sortedCreator = !sortedCreator;
    displaySnippets();
    console.log('Sorted by creator');
}

function sortDescription() {
    let testkeyword = 'KOREA'; // <- should be contents of searhbar
    let customList = [];
    for (let i = 0; i < snippetData.length; i++) {
      if (snippetData[i].description.toLowerCase().includes(testkeyword.toLowerCase())) {
          customList.push(snippetData[i])
      }
    }
    displaySnippets(customList);
    console.log('Sorted by keywords in description');

}


let sortedLanguage = false;
function sortLanguage() {
    let sortalg;
    if (sortedLanguage) {
        sortalg = function (a, b) {
            return a.language > b.language;
        };
    } else {
        sortalg = function (a, b) {
            return a.language < b.language;
        }
    }
    snippetData.sort(sortalg);
    sortedLanguage = !sortedLanguage;
    displaySnippets();
    console.log('Sorted by language');
}

function populateSnippetList() {
    let url = URL + '?cmd=list';
    
    httpGetAsync(url, function (response) {
        let formattedData = JSON.parse(/.*(\{\"status\".*$)/.exec(response)[1]);
        snippetData = JSON.parse(formattedData['snippets']);
        console.log(snippetData);
        displaySnippets();
    });
}


function displaySnippets(customList) {
    if (!customList) {
        customList = snippetData;
    }
    //clear the snippet list before adding to it to prevent duplicates
    document.getElementsByClassName('snippet-list')[0].innerHTML = "";
    
    for (let i = 0; i < customList.length; i++) {
            // Creates the snippet.
            let snippetContainer = document.createElement('div');
            snippetContainer.className = 'snippet';
            
            // Language and creator.
            let snippetHeader = document.createElement('div');
            snippetHeader.className = 'snippet-header';
            snippetHeader.innerHTML = customList[i].language + '<br />' + customList[i].creator;
            snippetContainer.appendChild(snippetHeader);
            
            let snippetDescription = document.createElement('div');
            snippetDescription.className = 'snippet-description';
            snippetDescription.innerText = customList[i].description;
            snippetContainer.appendChild(snippetDescription);
            
            let snippetCode = document.createElement('div');
            snippetCode.className = 'snippet-code';
            snippetCode.innerText = '/code/ /code/ /code/';
            snippetContainer.appendChild(snippetCode);
            
            //console.log(customList[i]);
            //console.log(customList[i].id);
            //console.log(customList[i].creator);
            //console.log(customList[i].description);
            //console.log(customList[i].language);
            
            document.getElementsByClassName('snippet-list')[0].appendChild(snippetContainer);
        }
}

function httpGetAsync(theUrl, callback) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            callback(xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}
