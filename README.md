# Overview
**Snippet Good** is an application being developed by Mark Cohen's Fall 2017 Software Engineering class at MCLA. The current purpose of this program is to display a list of code snippets to users, providing them a central place for their favorite reusable blocks of code. For example, a user might need a snippet of Java code that iterates through a list of names, and organizes them in descending order, returning the reorganized list. Programmers usually resort to search engines to find blocks of code online, but Snippet Good can provide a foundation to keep track of your favorite blocks of code!

This course places teams of students in an agile development environment where they must work together with other teams to build a functional and professional web application, striving to achieve all sprint goals each sprint, and its goal is to leave students with a deeper understanding of agile development.


# User Stories
## Release 1 - Viewing Snippets (VS)
- [x] **VS1 -** As an unauthenticated or authenticated user, I want to be able to view a list of snippet summaries that contain the creator, language, and snippet description so that I can use them when I am writing code.
- [x] **VS2 -** As an unauthenticated or authenticated user, I want to be able to filter or sort a list of snippets by creator, language, or description.
- [x] **VS3 -** As an unauthenticated or authenticated user, I want to be able to select a snippet in the list and view the code associated with the snippet.

## Release 2 - User Accounts (UA)
- [x] **UA1 -** As an unauthenticated or authenticated user, I want to be able to create a new user account.
- [x] **UA2 -** As an unauthenticated user, I want to be able to change my password by answering two security questions so that I can access my account if I have forgotten my password.
- [x] **UA3 -** As an unauthenticated user, I want to be able to login to my account.
- [x] **UA4 -** As an authenticated user, I want to be see visible clues that make it clear if I am currently logged into Snippet Good.
- [x] **UA5 -** As an authenticated user, I want to be able to logout of my account.

## Release 3 - Snippet Management (SM)
- [x] **SM1 -** As an authenticated user I want to be able to be able to create a new snippet and specify the snippet's language, description, and code.
- [x] **SM2 -** As an authenticated user I want to be able to be able to select from a list of predefined languages when associating a language with a new snippet.
- [x] **SM3 -** As an authenticated user I want to be able to be able to delete or edit snippets that I have created.
- [x] **SM4 -** As an authenticated user I want to be sure that other users cannot delete or edit snippets that I have created.
- 

<-- Convention -->

JavaScript

function verbNounName() {

    code goes here;
    
}

when declaring variables use let or const rather than var.  var has full
function scope which can lead to messy and confusing code.  let and const
both have the more traditional block scope you see in language like Java and
C/C++.

never define anonymouse functions on one line.
example:

don't do this ->
const myFunc = () => { do some stuff; };

do this ->
const myFunc = () => {
    do some stuff;
}


defining getters and setters are an exception to this rule
this is fine ->
getStuff() { return this.stuff; },
setStuff(stuff) { this.stuff = stuff } 



PHP
// write functional comments (ie listeners are here, etc.) to denote sections of related code.
function verbNounName() {
    
    code goes here;
    
}

for PHP use null rather than NULL.

when coding take human readability into account  ie:

.done(function(data) {
    if (data.status === "OK") {
        userAlert('success', 'Snippet Successfully Created.');
        getSnippets();
    } else {
        userAlert('danger',  data.errmsg);
    }
})
.fail(function(data) {
    userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
})


rather than:

.done(function(data) { if (data.status === "OK") { userAlert('success', 'Snippet Successfully Created.'); getSnippets(); } else { userAlert('danger',  data.errmsg); } }).fail(function(data) { userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.'); })
or something similarly unreadable.
