
import json
import urllib2

# be sure to make your applicaiton public by using the Window->Share menu item in Cloud 9
url = 'http://snippet-good-mclacs.c9users.io//CSCI452-FA17-Public/Server/php/crud.php?cmd=create'
jsonTxt = urllib2.urlopen(url).read()
print jsonTxt
json = json.loads(jsonTxt)
if json["status"] == "OK":
    print "Test passes"
else:
    print "Test fails"
