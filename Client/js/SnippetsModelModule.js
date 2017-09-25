(function SnippetsModelModule(global) {
    function SnippetsModel() {
        var snippets = [];
        var selectedSnippet = null;
        
        function fetchSelectedSnippet() {
            let id = selectedSnippet.data()[0];
            var result = snippets.filter(function( obj ) {
                return obj.id == id;
            });
            return result[0];
        }

        return {
            getSnippets(){ return snippets; },
            getSnippetRow() { return selectedSnippet; },
            updateSnippetsList(newList) { snippets = newList; },
            setSelectedSnippet(row) { selectedSnippet = row; },
            getSelectedSnippet: fetchSelectedSnippet,
        };
    }
    
    try {
        global.model = new SnippetsModel();
    } catch (ex) {
        console.error('Model failed to initialize:');
        console.trace();
    }
})(window);