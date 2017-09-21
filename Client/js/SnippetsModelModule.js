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
    
    function Filters() {
        var orderBy = '';
        var filterBy = {};
        
        function defaultOrdering() { orderBy = ''; }
        function defaultFilters() { filterBy = {}; }
        function addFilter(property, value) { filterBy[property] = value; }
        function removeFilter(property) { delete filterBy[property]; }
        function order(property) { orderBy = property; }
        
        return {
            getOrder() { return orderBy; },
            getFilters() { return filterBy; },
            defaultOrdering,
            defaultFilters,
            addFilter,
            removeFilter,
            setOrder: order,
        };
    }
    
    try {
        global.model = new SnippetsModel();
        global.filters = new Filters();
    } catch (ex) {
        console.error('Model failed to initialize:');
        console.trace();
    }
})(window);