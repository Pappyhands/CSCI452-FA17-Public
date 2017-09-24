(function SnippetsModelModule(global) {
    function SnippetsModel() {
        var snippets = [];
        var selectedSnippet = 0;
        function updateSnippetsList(newList) {
            snippets = newList;
        }
        
        function getSelectedSnippet() {
            var result = snippets.filter(function( obj ) {
                return obj.id == selectedSnippet;
            });
            return result[0];
        }
        
        function setSelectedSnippet(id) { selectedSnippet = id; }
        
        return {
            getSnippets(){ return snippets; },
            updateSnippetsList,
            getSelectedSnippet,
            setSelectedSnippet,
        };
    }
    
    try {
        global.model = new SnippetsModel();
    } catch (ex) {
        console.error('Model failed to initialize:');
        console.trace();
    }
})(window);