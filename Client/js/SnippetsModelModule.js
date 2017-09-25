// SnippetsModelModule is an IIFE (immediately invoked function expression)
// which means it is run as soon as it is defined
// SnippetsModelModule defines a constructor for our model class and constructs
// our object as a global variable
(function SnippetsModelModule(global) {
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
            updateSnippetsList(newList) { snippets = newList },
            setSelectedSnippet(row) { selectedSnippetRow = row; },
            getSnippetRow() { return selectedSnippetRow; },
            getSelectedSnippet: fetchSelectedSnippet,
        };
    }
    
    try {
        global.model = new SnippetsModel();
    } catch (ex) {  // in case anything goes wrong here.
        console.error('Model failed to initialize:');
        console.trace();
    }
})(window);