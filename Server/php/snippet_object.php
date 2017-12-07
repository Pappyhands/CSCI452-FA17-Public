<?php
    class SnippetObject {
        
        private $snippet_id = null;
        private $creator_id = null;
        private $language_id = null;
        private $description = null;
        private $snippet_text = null;
        
        public function __construct($id, $creator, $language_id, $description, $snippet_text) {
            $this->setID($id);
            $this->setCreator($creator);
            $this->setLanguage($language_id);
            $this->setDescritption($description);
            $this->setSnippetText($snippet_text);
        }
        
        public function setCreator($creator) {
            $this->creator_id = $creator;
        }
        
        public function getCreator() {
            return $this->creator_id;
        }
        
        public function setLanguage_id($language_id) {
            $this->language_id = $language_id;
        }
        
        public function getLanguage_id() {
            return $this->language_id;
        }
        
        public function setDescritption($description) {
            $this->description = $description;
        }
        
        public function getDescription() {
            return $this->description;
        }
        
        public function setSnippetText($snippet_text) {
            $this->snippet_text = $snippet_text;
        }
        
        public function getSnippetText() {
            return $this->snippet_text;
        }
        
        public function setID($id) {
            $this->snippet_id = $id;
        }
        
        public function getID() {
            return $this->snippet_id;
        }
    }
?>