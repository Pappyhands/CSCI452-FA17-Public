/* global $ SnippetsModel snippetsTable */

const getUrl = window.location;
const baseUrl = getUrl.protocol + '//' + getUrl.host + '/';
const SnippetsUrl = baseUrl + 'Server/php/snippets.php';
const registerUrl = baseUrl + 'Server/php/create_user.php';
const model = new SnippetsModel();

// initialize javascript
$(document).ready(function() {
    
    // initialize datatable
    window.snippetsTable = $('#snippets-table').DataTable({
        'columnDefs': [
            {
                'targets': [0],
                'visible': false,
                'searchable': false,
            }
        ],
    });
    
    // datable row click event listener
    $('#snippets-table tbody').on( 'click', 'tr', function () {
        model.setSelectedSnippet(snippetsTable.row(this));
        updateSnippet();
    });
    
    
    // listen for click on submit buttons in modals
    $('#register-submit').on('click', function(e){
       $('#registerUserHidden').click(); 
    });
    
    $('#recover-submit').on('click', function(e){
        $('#recoverPasswordHidden').click();
    })
    
    //listen for form submit events
    $('form#registerUserForm').submit(function(e) {
        registerUser(e);   
    });
    
    $('form#recoverPasswordForm').submit(function(e) {
        recoverPassword(e); 
    });
    
    // make initial ajax calls
    getSnippets();
}); 



// VIEW UI Handler

function updateSnippet() {
    var snippet = model.getSelectedSnippet();
    var row = model.getSnippetRow();
    $('#snippets-table tbody')
        .find('tr.selected')
        .removeClass('selected');
    $(row.node()).addClass('selected');
    var code = $('#snippet-frame')
        .find('code')
        .text(snippet.code);
}

function updateView() {
    let snippets = model.getSnippets();
    console.log(snippets);
    $.each(snippets, function(index, snippet) {
        snippetsTable.row.add([
            snippet['id'],
            snippet['creator'],
            snippet['description'],
            snippet['language']
        ]);
    });
    snippetsTable.draw();
}

function getSnippets() {
    let url = SnippetsUrl + '?cmd=list';
    $.get(url, function (response) {
        console.log(response);
        let snippetData = JSON.parse(response['snippets']);
        model.setSnippetsList(snippetData);
        updateView();
    });
}

// displays a user alert.  accepted types are primary, secondary, success, warning, danger, info, light, dark
function userAlert(type, text) {
    var alertMarkup = '<div id="alert" class="alert alert-dismissible fade show col-12" role="alert">\n' +
  				      '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
    			      '    <span aria-hidden="true">&times;</span>\n' +
  				      '  </button>\n' +
				      '</div>';
	var result = $(alertMarkup).addClass('alert-' + type).append(text);
    $('#user-alert-container').empty().append(result)
}

// user and password submit
function registerUser(e){
    $('#alert').alert();
    
    var name = $(e.target).find('input[name="name"]'); 
    var password = $(e.target).find('input[name="password"]');
    if(name.get(0).checkValidity() && password.get(0).checkValidity()){
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=create_user';
        $.post(url, {
        name: name.val(),
        password: password.val() ,
    }).done(function( data ) {
        name.val('');
        password.val('');
        userAlert('success', 'User successfully registered.  Welcome!');
        $('#registerModal').modal('hide')
    });
    } else {
        return true;
    }
    
}


// function to recover password based on two security questions
function recoverPassword(e){
    
    var securityAnswer1 = $(e.target).find('input[name="securityAnswer1"]'); 
    var securityAnswer2 = $(e.target).find('input[name="securityAnswer2"]');
    var username = $(e.target).find('input[name="name"]'); 
    var newPassword = $(e.target).find('input[name="newPassword"]'); 
    var confirmNewPassword = $(e.target).find('input[name="verifyNewPassword"]'); 
    
    if(securityAnswer1.get(0).checkValidity() && securityAnswer2.get(0).checkValidity() && username.get(0).checkValidity() && newPassword.get(0).checkValidity() && confirmNewPassword.get(0).checkValidity()){
        e.preventDefault();
        let url = SnippetsUrl + '?cmd=update_user';
        $.post(url, {
        securityAnswer1: securityAnswer1.val(),
        securityAnswer2: securityAnswer2.val() ,
    }).done(function( data ) {
        securityAnswer1.val('');
        securityAnswer2.val('');
        $('#registerModal').modal('hide')
        if(data.status === "OK") {
            //success msg for userAlert
            userAlert('success', 'User successfully reset.');
        } else {
            //fail msg for userAlert
            userAlert('danger', data.errmsg);
        }
    });    
    } else {
        return true;
    }
    
}