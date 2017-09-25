(function SnippetsModelModule(global) {
    function SnippetsModel() {
        var snippets = {};
        function updateSnippetsList(newList) {
            snippets = newList;
        }
        return {
            getSnippets(){ return snippets; },
            updateSnippetsList,
        };
    }
    
    try {
        global.model = new SnippetsModel();
    } catch (ex) {
        console.error('Model failed to initialize:');
        console.trace();
    }
})(window);