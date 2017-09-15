import json
import urllib2

url = 'http://software-engineering-proudfoot.c9users.io//Server/Test/php/snippets.php?cmd=list'
jsonTxt = urllib2.urlopen(url).read()

testPassed = True
errors = []

try: # catches the case where the response string is not legal json syntax
    obj = json.loads(jsonTxt) 
    
    # Expect status "OK"
    if obj["status"] != "OK":
        testPassed = False
        errors << "Expecting status: '{0}' got status: '{1}'".format('OK', obj["status"])
    
    json2 = json.loads(obj["snippets"])
    
    # Expect snippets to be an array
    if not isinstance(json2, list):
        testPassed = False
        errors << "Expected snippets to be an array"
    
    #check the values of the sql test data
    if json2[0]["creator"] != "WizardProfessor":
        testPassed = False
    if json2[1]["language"] != "SQL":
        testPassed = False
    if json2[2]["id"] != "3":
        testPassed = False
    if json2[3]["description"] != "Database Connection":
        testPassed = False
        
except:
    testPassed = false
    errors << "Response is not a legal JSON format"

if testPassed == True:
    print("Tests Passed")
else:
    print("Tests Failed:\n")
    for error in errors:
        print(error + "\n")