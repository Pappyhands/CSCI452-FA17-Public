import json
import urllib2

# be sure to make your applicaiton public by using the Window->Share menu item in Cloud 9
url = 'http://snippet-good-mclacs.c9users.io//CSCI452-FA17-Public/Server/php/crud.php?cmd=list'

testPassed = True

jsonTxt = urllib2.urlopen(url).read()
print jsonTxt

#check if the response is valid JSON
try:
    json = json.loads(jsonTxt)
except ValueError, e:
    print "Invalid JSON Error: %s" % e
    
#check the success of the response
if json["status"] != "OK":
    testPassed = False
    print "Server response unsuccessful"
    
#check for the snippet array
if json["snippet"] is None:
    testPassed = False
    print "snippets not found"
    
#


if testPassed == True:
    print "Test passed"
else:
    print "Test fails"

