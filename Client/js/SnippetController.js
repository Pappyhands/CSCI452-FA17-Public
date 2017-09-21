const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const URL = baseUrl + 'Server/php/snippets.php';

$(document).ready(function() {
    populateSnippetList();
});

let snippetData;

let filter = document.getElementById('filter');
let switch1 = document.getElementById('switch1');
let switch2 = document.getElementById('switch2');
let switch4 = document.getElementById('switch4');

switch1.onmouseup = sortCreator;
filter.onmouseup = filterList;
switch2.onmouseup = sortLanguage;

let searchBox = document.getElementsByName('search')[0];

let radioDescription = document.getElementById('filter_description');
let radioCreator = document.getElementById('filter_creator');
//let radioLanguage = document.getElementById('filter_langauge');


let languageSelect = document.getElementsByTagName('select')[0];



function filterList(){
    if (radioDescription.checked) {
        filterByDescription();
    }
    else if (radioCreator.checked) {
        filterByCreator();
    }
}

function filterByCreator(){
    let data = filterByLanguage();
    let customList = [];
    for (let i = 0; i < data.length; i++) {
        if (data[i].creator.toLowerCase().includes(searchBox.value.toLowerCase())) {
            customList.push(data[i])
        }
    }
    displaySnippets(customList);
    if(customList.length === 0){
        alert("No results found for creator \"" + searchBox.value + "\".");
    }
}

function filterByDescription() { // <- should be contents of searhbar
    let data = filterByLanguage();
    let customList = [];
    for (let i = 0; i < data.length; i++) {
        if (data[i].description.toLowerCase().includes(searchBox.value.toLowerCase())) {
            customList.push(data[i])
        }
    }
    displaySnippets(customList);
    if(customList.length === 0){
        alert("No results found for description \"" + searchBox.value + "\".");
    }
}

function filterByLanguage() {
    let selectedLang = languageSelect.options[languageSelect.selectedIndex].value;
    if (selectedLang === 'default') {
        return snippetData;
    }
    let customList = [];
    for (let i = 0; i < snippetData.length; i++) {
        if (snippetData[i].language.toLowerCase() === selectedLang) {
            customList.push(snippetData[i])
        }
    }
    return customList;
    //displaySnippets(customList);
}


let sortedCreator = false;
function sortCreator() {
    let sortAlgorithm;
    if (sortedCreator)
        sortAlgorithm = (a, b) => a.creator < b.creator;
    else 
        sortAlgorithm = (a, b) => a.creator > b.creator;
    snippetData.sort(sortAlgorithm);
    sortedCreator = !sortedCreator;
    displaySnippets();
    console.log('Sorted by creator');
}

let sortedLanguage = false;
function sortLanguage() {
    let sortalg;
    if (sortedLanguage)
        sortalg = (a, b) => a.language < b.language;
    else
        sortalg = (a, b) => a.language > b.language;
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
        if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
            callback(xmlHttp.responseText);
        }
    }
    xmlHttp.open("GET", theUrl, true);
    xmlHttp.send(null);
}
