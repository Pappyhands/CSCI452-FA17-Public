import json
import urllib2

# be sure to make your applicaiton public by using the Window->Share menu item in Cloud 9
url = 'http://software-engineering-proudfoot.c9users.io//Server/Test/php/snippets.php?cmd=list'
jsonTxt = urllib2.urlopen(url).read()

testPassed = True

obj = json.loads(jsonTxt)
    
#check the success of the response
if obj["status"] != "OK":
    testPassed = False
    print( "Server response unsuccessful")
    

json2 = json.loads(obj["snippets"])

#check the type of 'snippets'
if not isinstance(json2, list):
    testPassed = False

#check the values of the sql test data
if json2[0]["creator"] != "WizardProfessor":
    testPassed = False
if json2[1]["language"] != "SQL":
    testPassed = False
if json2[2]["id"] != "3":
    testPassed = False
if json2[3]["description"] != "Database Connection":
    testPassed = False
    
if testPassed == True:
    print( "Test passed")
else:
    print( "Test fails")
