# HTML-PHP-Mongodb-form
HTML form with PHP validation to allow for the capturing of data into a Mongo database

I was asked to complete this task in an interview. As I am just starting out programming, forgive me for my shortcomings, but I thought this would be useful for someone who wants quick startup code for an HTML form with PHP validation - posting it to a MongoDB. I am sure you can improve on it and add safety measures. Maybe in 15 years time I will look back on this and realise how much I did not know. Alas.

1. You will need to have PHP NTS 8.3 or later, MongoDB 1.18.0 or later and Laravel Herd installed. I also installed Composer and MongoDB Compass to make navigating easier. Make sure you add the "extension=mongodb" extension to your php.ini file if it is not added automatically. You can check if the extension is running by creating a php file with the function php.info() and then running the file from your web browser and checking if "mongodb" appears under the list.
2. Once you get MongoDB up and running, connect to your local host server via the MongoDB Compass. It should be automatically set to 27017.
3. If you are struggling to get Herd to run, add "C:\Users\Admin\.config\herd\bin\nvm" or the equivalent on your system to your environmental variables PATH.
4. I placed my project folder, titled "test1", in the Herd folder on my C:/Users/Admin/Herd. The main file should be named "index.php". If you make a folder in the Herd location with an index.php file in it, Herd will automatically setup a DNS for you, so you can go to your web browser and type "yourfolder.test" and it should load up the index.php file in your folder.
5. Once eveything above is up and running, you should be able to submit records from the web browser and they will appear in the MongoDB database. You can view the records through the MongoDB Compass.
