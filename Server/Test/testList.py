import json
import urllib2
import sys

url = 'http://software-engineering-proudfoot.c9users.io//Server/Test/php/snippets.php?cmd=list'
jsonTxt = urllib2.urlopen(url).read()
print(jsonTxt)
testPassed = True
errors = []

try: # catches the case where the response string is not legal json syntax
    obj = json.loads(jsonTxt) 
    
    # Expect status "OK"
    if obj["status"] != "OK":
        testPassed = False
        errors.append("Expecting status: '{0}' got status: '{1}'".format('OK', obj["status"]))
    
    json2 = json.loads(obj["snippets"])
    
    
    # Expect snippets to be an array
    if not isinstance(json2, list):
        testPassed = False
        errors.append("Expected snippets to be an array")
    
    # check the values of the sql test data
    # First Snippet
    if json2[0]["creator"] != "Aaron Smith":
        testPassed = False
        errors.append("Expecting creator: '{0}' got creator: '{1}'".format('AaronSmith', json2[0]["creator"]))
    if json2[0]["language"] != "Java":
        testPassed = False
        errors.append("Expecting language: '{0}' got language: '{1}'".format('Java', json2[0]["language"]))
    if json2[0]["description"] != "Print out Hello World!":
        testPassed = False
        errors.append("Expecting description: '{0}' got description: '{1}'".format('Print out Hello World!', json2[0]["description"]))
        
    # Second Snippet
    if json2[1]["creator"] != "Richard Dude":
        testPassed = False
        errors.append("Expecting creator: '{0}' got creator: '{1}'".format('Richard Dude', json2[1]["creator"]))
    if json2[1]["language"] != "SQL":
        testPassed = False
        errors.append("Expecting language: '{0}' got language: '{1}'".format('SQL', json2[1]["language"]))
    if json2[1]["description"] != "Create Snippet_Data table":
        testPassed = False
        errors.append("Expecting description: '{0}' got description: '{1}'".format('Create Snippet_Data table', json2[1]["description"]))
        
    # Third Snippet
    if json2[2]["creator"] != "Aaron Smith":
        testPassed = False
        errors.append("Expecting creator: '{0}' got creator: '{1}'".format('AaronSmith', json2[2]["creator"]))
    if json2[2]["language"] != "HTML":
        testPassed = False
        errors.append("Expecting language: '{0}' got language: '{1}'".format('HTML', json2[2]["language"]))
    if json2[2]["description"] != "Custom Div":
        testPassed = False
        errors.append("Expecting description: '{0}' got description: '{1}'".format('Custom Div', json2[1]["description"]))

        
    # Fourth Snippet
    if json2[3]["creator"] != "WizardProfessor":
        testPassed = False
        errors.append("Expecting creator: '{0}' got creator: '{1}'".format('WizardProfessor', json2[3]["creator"]))
    if json2[3]["language"] != "PHP":
        testPassed = False
        errors.append("Expecting language: '{0}' got language: '{1}'".format('PHP', json2[3]["language"]))
    if json2[3]["description"] != "Database Connection":
        testPassed = False
        errors.append("Expecting description: '{0}' got description: '{1}'".format('Database Connection', json2[1]["description"]))
        
        
except:
    testPassed = False
    errors.append("Response is not a legal JSON format: ")
    print(sys.exc_info())

if testPassed == True:
    print("Tests Passed")
else:
    print("Tests Failed:\n")
    for error in errors:
        print(error + "\n")