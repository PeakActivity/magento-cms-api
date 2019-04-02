## Magento Custom API for CMS Block & Page

Custom API to retrieve CMS data page or block from your magento installation with two methods:

* SOAP API (Based on standard: soapui.org)

---

### SOAP API

SOAP API must be used by registered user from magento admin area, take a look at file "api-test.php"
It's some test script with PHP for this module SOAP API.

How to Use:

* Login to Admin Area
* Go to menu: System > Web Services > SOAP/XML-RPC - Roles
* Add role name with your admin password
* On "Role Resources" make sure you have checked "CMS" (at the end of lists) and all the childs checkbox
* Save
* Go to menu: System > Web Services > SOAP/XML-RPC > Users
* Add your user for SOAP client here, make sure you checked User Role has created before
* Save

Add Username and API Key to file "api-test.php"
```
$API_username   = '';  // Insert your API Username
$API_Key        = '';  // Insert your API Key
```

To test, api-test.php has some query args to modify your result, example:

* api-test.php?list=page&sortby=title
* api-test.php?list=block&sortby=updated
* api-test.php?content=page&id=5
* api-test.php?content=block&id=3

All allowed key to sortby:

* page: id, title, created, updated, sort
* block: id, title, created, updated

---

Copyright &copy; 2016 fauzie. Code with &hearts; at Kemana Office.
