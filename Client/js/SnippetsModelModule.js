// Snippets Model class constructor
function SnippetsModel() {
    var snippets = [];
    var selectedSnippetRow = null;
    
    // finds the data representation of the dataTable row
    function fetchSelectedSnippet() {
        var id = selectedSnippetRow.data()[0];
        var result = snippets.filter(function(elem, idx){
           return elem.id == id;
        })[0];
        return result;
    }

    // public-accessible functions for this module
    // you can't access snippets or selectedSnippetRow or fetchSelectedSnippet
    // from outside this context, but the below functions work fine in SnippetController.js
    return {
        getSnippets(){ return snippets; },
        setSnippetsList(newList) { snippets = newList },
        setSelectedSnippet(row) { selectedSnippetRow = row; },
        getSnippetRow() { return selectedSnippetRow; },
        getSelectedSnippet: fetchSelectedSnippet,
    };
    
}
