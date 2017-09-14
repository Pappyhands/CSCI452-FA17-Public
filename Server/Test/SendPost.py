import json
import urllib2

# be sure to make your applicaiton public by using the Window->Share menu item in Cloud 9
url = 'http://software-engineering-proudfoot.c9users.io//Server/php/snippets.php?cmd=list'
jsonTxt = urllib2.urlopen(url).read()
print(jsonTxt)

testPassed = True

json = json.loads(jsonTxt)
    
#check the success of the response
if json["status"] != "OK":
    testPassed = False
    print( "Server response unsuccessful")
    
#check for the snippet array
if "snippets" not in json:
    testPassed = False
    print( "snippets not included in data")
#check the values of the array
#for i in json["snippets"]: 
#   if not isinstance(i["id"], int):
#       testPassed = False
#   if not isinstance(i["creator"], str):
#       testPassed = False
#   if not isinstance(i["description"], str):
#       testPassed = False
#   if not isinstance(i["language"], str):
#       testPassed = False



if testPassed == True:
    print( "Test passed")
else:
    print( "Test fails")

