/* global $ SnippetsModel snippetsTable */

const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const SnippetsUrl = baseUrl + 'Server/php/commands.php';
const model = new SnippetsModel();
let currentUsername;

// 
$(document).ready(function() {
    // initialize datatable
    window.snippetsTable = $('#snippets-table').DataTable({
        // "scrollY": "600px",
        // "scrollCollapse": true,
        // "paging":         false,
        'columnDefs': [{
            'targets': [0],
            'visible': false,
            'searchable': false,
        }],
    });
    
    // datable row click event listener
    $('#snippets-table tbody').on( 'click', 'tr', function () {
        model.setSelectedSnippet(snippetsTable.row(this));
        updateActiveSnippet();
    });
    
    // 
    $('#deleteSnippetButton').on('click', deleteSnippet);

    $('#forgot-password-button').on('click', () => { $('#login').transitionTo($('#recoverPassword'));  });
    
    $('#back-to-login').on('click', () => { $('#recoverPassword').transitionTo($('#login')); });
    
    $('#loginModal').on('hidden.bs.modal', () => { $('#recoverPassword').transitionTo($('#login')); });
    
    $('#updateSnippetModal').on('show.bs.modal', updateSnippetForm);
    
    // click event listeners on modal submit buttons
    // these each trigger a click event on a hidden submit button in their respective forms
    
    $('#login-submit').on('click', function(e) {
        $('#loginUserHidden').click();
    });
    
    $('#register-submit').on('click', function(e) {
       $('#registerUserHidden').click(); 
    });
    
    $('#update-snippet-submit').on('click', function(e) {
        $('#updateSnippetHidden').click();
    });
    
    $('#recover-submit').on('click', function(e) {
        $('#recoverPasswordHidden').click();
    });
    //
     $('#snippet-submit').on('click', function(e) {
        $('#submitSnippetHidden').click();
    });
    
    // listen for form submit events
    $('form#loginUserForm').on('submit', function(e) {
        loginUser(e); 
    });
    
    $('form#updateSnippetForm').on('submit', function(e) {
        updateSnippet(e);   
    });
    
    $('form#registerUserForm').on('submit', function(e) {
        registerUser(e);   
    });
    
    $('form#recoverPasswordForm').on('submit', function(e) {
        recoverPassword(e); 
    });
    
    $('form#snippetEntryForm').on('submit', function(e) {
        createSnippet(e);
    });
    
    //change this when html team adds button
    $('#logout-button').on('click', function(e) {
        logoutUser();
    });
    
    // make initial ajax calls
    getSnippets();
    getUserSession();
    getLanguages();
}); 


// view functions
// updates view for active snippet
function updateActiveSnippet() {
    var snippet = model.getSelectedSnippet();
    var row = model.getSnippetRow();
    $('#snippets-table tbody')
        .find('tr.selected')
        .removeClass('selected');
    $(row.node()).addClass('selected');
    var code = $('#snippet-frame')
        .find('code')
        .text(snippet.code);
        
    if (snippet.creator == currentUsername) {
        $('#snippet-owner-controls').fadeIn(167);
    } else {
        $('#snippet-owner-controls').fadeOut(167);
    }
}

// updates the view for the snippets list
function updateSnippetList() {
    let snippets = model.getSnippets();
    snippetsTable.clear();
    $.each(snippets, function(index, snippet) {
        snippetsTable.row.add([
            snippet['id'],
            snippet['creator'],
            snippet['description'],
            snippet['language'],
        ]);
    });
    snippetsTable.draw();
}

// displays a user alert.  accepted types are primary, secondary, success, warning, danger, info, light, dark
function userAlert(type, text) {
    var alertMarkup = '<div id="alert" class="alert alert-dismissible fade show col-12" role="alert">\n' +
  				      '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
    			      '    <span aria-hidden="true">&times;</span>\n' +
  				      '  </button>\n' +
				      '</div>';
	var result = $(alertMarkup).addClass('alert-' + type).append(text);
    $('#user-alert-container').empty().append(result);
}

//checking if you are logged in changes view depending on whether or not the user is logged in or not.
function updateLoginStatus() {
    var currentOpenNavbar = $('#nav-content').find('div.navbar-nav:visible');
    var nextOpenNavbar;
    if (!currentUsername) {
        nextOpenNavbar = $('#logged-out-nav');
    } else {
        $('#login-indicator').text(currentUsername);
        nextOpenNavbar = $('#logged-in-nav');
    }
    if (currentOpenNavbar.attr('id') != nextOpenNavbar.attr('id')){
        currentOpenNavbar.transitionTo(nextOpenNavbar);    
    }
}

//populate language drop down
function updateLanguageList(){
    var languageDropDown = $('#languageSelect').empty();
    var languages = model.getLanguageList();
    console.log(languages)
    for(var i = 0; i < languages.length; i++){
        var option = document.createElement('option');
        option.innerText = languages[i]['language_name'];
        option.setAttribute('language_id', languages[i]['id']);
        languageDropDown.append($(option));
    }
}

function updateSnippetForm() {
    let currentSnippet = model.getSelectedSnippet();
    
    let snippetName = currentSnippet.description;
    let snippetText = currentSnippet.code;
    
    let target = $('#updateSnippetForm');
    target.find('input[name="snippetName"]').val(snippetName);
    target.find('textarea[name="snippetText"]').val(snippetText);
}


// GET ajax calls
function getSnippets() {
    let url = SnippetsUrl + '?cmd=list';
    $.get(url, function(response) {
        let snippetData = JSON.parse(response['snippets']);
        model.setSnippetsList(snippetData);
        updateSnippetList();
    });
}

function getUserSession() {
    let url = SnippetsUrl + '?cmd=get_user_session';
    $.get(url, function(response) {
        currentUsername = response.username
        updateLoginStatus();
    });
}

function getLanguages() {
    let url = SnippetsUrl + '?cmd=list_languages';
    $.get(url, function(response) {
        let languageData = JSON.parse(response['languages']);
        model.setLanguageList(languageData);
        updateLanguageList();
    });
}
// user and password submit
function registerUser(e) {
    var target = $(e.target),
        name =            target.find('input[name="name"]'), 
        password =        target.find('input[name="password"]'),
        confirmPassword = target.find('input[name="confirmPassword"]'),
        securityAnswer1 = target.find('input[name="securityAnswer1"]'), 
        securityAnswer2 = target.find('input[name="securityAnswer2"]');
    var formValid = name.get(0).checkValidity() && 
                    password.get(0).checkValidity() && 
                    confirmPassword.get(0).checkValidity() &&
                    securityAnswer1.get(0).checkValidity() && 
                    securityAnswer2.get(0).checkValidity();
    if (formValid) {
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=create_user';
        $.post(url, {
            name: name.val(),
            password: password.val(),
            confirmPassword: confirmPassword.val(),
            securityAnswer1: securityAnswer1.val(),
            securityAnswer2: securityAnswer2.val(),
        })
        .done(function(data) {
            if (data.status === "OK") {
                userAlert('success', 'User successfully registered.  Welcome!');
            } else {
                userAlert('danger',  data.errmsg);
            }
        })
        .fail(function(data) {
            userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
        })
        .always(function(data) {
            name.val('');
            password.val('');
            confirmPassword.val('');
            securityAnswer1.val('');
            securityAnswer2.val('');
            $('#registerModal').modal('hide');
        });
    } else { return true; }
}

// login function 
function loginUser(e){
    var target = $(e.target),
        username =      target.find('input[name="name"]'),
        password =      target.find('input[name="password"]');
    var formValid = username.get(0).checkValidity() &&
                    password.get(0).checkValidity();
    if (formValid) {
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=login_user';
        $.post(url, {
            name: username.val(),
            password: password.val(),
        }).done(function(response) {
            if (response.status === 'OK') {
                userAlert('success', 'Logged in successfully.');
                currentUsername = response.username;
                updateLoginStatus();
            } else {
                userAlert('danger', response.errmsg);
            }
        }).fail(function(response) {
            userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
           
        }).always(function(response) {
            username.val('');
            password.val('');
            $('#loginModal').modal('hide');
        });
    } else { return true; }
}

// logout function
function logoutUser() {
    let url = SnippetsUrl + '?cmd=logout_user';
    $.get(url)
    .done(function(){
        userAlert('success', 'User logged out!');
        currentUsername = null;
        updateLoginStatus();
    })
    .fail(function(){
        userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
    })
    .always(function(){
        // there is nothing to do here, should we remove this?
    });
    
}
// function to recover password based on two security questions
function recoverPassword(e){
    //e.target points to the DOM where input name is equal to the name of the modal form (ie. '#recoverPassword' form)
    var target = $(e.target),
        securityAnswer1 =    target.find('input[name="securityAnswer1"]'), 
        securityAnswer2 =    target.find('input[name="securityAnswer2"]'),
        username =           target.find('input[name="name"]'),
        newPassword =        target.find('input[name="newPassword"]'),
        confirmNewPassword = target.find('input[name="verifyNewPassword"]'); 
    var formValid = securityAnswer1.get(0).checkValidity() &&
                    securityAnswer2.get(0).checkValidity() &&
                    username.get(0).checkValidity() &&
                    newPassword.get(0).checkValidity() &&
                    confirmNewPassword.get(0).checkValidity();
    if (formValid) {
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=update_user';
        $.post(url, {
            securityAnswer1: securityAnswer1.val(),
            securityAnswer2: securityAnswer2.val(),
            name: username.val(),
            newPassword: newPassword.val(),
            verifyNewPassword: confirmNewPassword.val(),
        })
        .done(function(response) { //done is not being called and the new passwords
            if (response.status === 'OK') {
                userAlert('success', 'User successfully reset.');
            } else {
                userAlert('danger', response.errmsg);
            }
        })
        .fail(function(response) {
            userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
        })
        .always(function(response) {
            securityAnswer1.val(''); // reset form
            securityAnswer2.val('');
            username.val('');
            newPassword.val('');
            confirmNewPassword.val('');
            $('#loginModal').modal('hide');
        });
    } else { return true; } // when form isn't valid
}

// new snippet creation submit
function createSnippet(e) {
    var target = $(e.target),
        snippetName =     target.find('input[name="snippetName"]'),
        language =        target.find('select'),
        snippetText =     target.find('textarea[name="snippetText"]');
    var formValid = snippetName.get(0).checkValidity() && 
                    snippetText.get(0).checkValidity();
    if (formValid) {
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=create_snippet';
        $.post(url, {
            snippetName: snippetName.val(),
            language: language.find(":selected").attr('language_id'),
            snippetText: snippetText.val(),
        })
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
        .always(function(data) {
            snippetName.val('');
            language.val('');
            snippetText.val('');
            $('#snippetEntryModal').modal('hide');
        });
    } else { return true; }
}

// update snippet creation submit
function updateSnippet(e) {
    
    // $snippetID, $code, $username
    
    var target = $(e.target),
        snippetName =     target.find('input[name="snippetName"]'), // THESE CHANGE (?)
        snippetText =     target.find('textarea[name="snippetText"]'); // THESE CHANGE (?)
    var formValid = snippetName.get(0).checkValidity() && 
                    snippetText.get(0).checkValidity();
    if (formValid) {
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=update_snippet';
        $.post(url, {
            snippet_id: model.getSelectedSnippet().id,
            snippetName: snippetName.val(),
            snippetText: snippetText.val(),
        })
        .done(function(data) {
            if (data.status === "OK") {
                userAlert('success', 'Snippet Successfully Updated.');
                getSnippets();
            } else {
                userAlert('danger',  data.errmsg);
            }
        }) 
        .fail(function(data) {
            userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
        })   
        .always(function(data) {
            snippetName.val('');
            snippetText.val('');
            $('#updateSnippetModal').modal('hide');
        });
    } else { return true; }
}

// delete a snippet
function deleteSnippet(e) {
    e.preventDefault();
    let url = SnippetsUrl + '?cmd=delete_snippet';
    let selectedSnippetID = model.getSelectedSnippet().id;
    $.post(url, {
        snippet_id: selectedSnippetID,
    })
    .done(function(data) {
        if (data.status === "OK") {
            userAlert('success', 'Snippet successfully deleted.');
            getSnippets();
            $('#snippets-table tbody tr:first').click();
        } else {
            userAlert('danger',  data.errmsg);
        }
    })
    .fail(function(data) {
        userAlert('danger', 'Snippet Bad! The server monkeys left a wrench in the code.');
    })
}


//Helper functions

$.fn.extend({
    transitionTo(next) {
       return this.fadeOut(167, () => { next.fadeIn(167); });
    },
});