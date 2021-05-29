#WundermanThompson Import

This module provides ability to import Customers using CSV or JSON file. 

#Installation 
These commands must be executed at the root level of your Magneto 2 project

Install the WundermanThompson Import module :::

```bash
composer require wundermanthompson/module-import dev-master
```
Remove old generated folder and cache
```bash
rm -rf generated/ var/cache
```

Enable module
```bash
bin/magento module:enable WundermanThompson_Import
```

Regenerate generated and compiler related resources
```bash
bin/magento setup:di:compile
```

Deploy static content
```bash
bin/magento setup:static-content:deploy -s "standard"
```

Flush Magento cache
```bash
bin/magento cache:flush
```

Upgrade the Magento application
```bash
bin/magento s:up --keep-generated
```

Check if you're on developer or production mode
```bash
bin/magento deploy:mode:show
```

Set appropriate permissions
```bash
/ 644 permission for files
find . -type f -exec chmod 644 {} \; 
```bash

```bash
// 755 permission for directory
find . -type d -exec chmod 755 {} \; 
```bash


#Usage
To import customers via CSV or JSON:

1. Go to Console.
2. Cd your root magento2 directory
3. Execute below commands to import customer
3-a.) bin/magento wundermanthompson_import sample-csv sample.csv
3-b.) bin/magento wundermanthompson_import sample-json sample.json
