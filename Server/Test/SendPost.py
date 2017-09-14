import json
import urllib2

!be sure to make your applicaiton public by using the Window->Share menu item in Cloud 9
url = 'http://ide.c9.io/proudfoot/software-engineering/Server/php/snippets.php?cmd=list'
jsonTxt = urllib2.urlopen(url).read()
print jsonTxt

testPassed = True

!check if the response is valid JSON
try:
    json = json.loads(jsonTxt)
except ValueError, e:
    print "Invalid JSON Error: %s" % e
    testPassed = False
    
!check the success of the response
if json["status"] != "OK":
    testPassed = False
    print "Server response unsuccessful"
    
!check for the snippet array
if json["snippets"] is None:
    testPassed = False
    print "snippets not found"
    
!check the values of the array
for i in json["snippets"]: 
   if not isinstance(i["id"], int):
       testPassed = False
   if not isinstance(i["creator"], str):
       testPassed = False
   if not isinstance(i["description"], str):
       testPassed = False
   if not isinstance(i["language"], str):
       testPassed = False



if testPassed == True:
    print "Test passed"
else:
    print "Test fails"

