Installation notes:

There need to use PHP&MySQL/Node.JS/Composer

1/ Copy the files of project to web server subfolder like "/var/www/project".
2/ There need to launch in the project's folder so command:
  chmod -R 777 storage 


3/ Then need to created the new database and edited the .env to put there your database conection settings.

4/Use the comand: php artisan migrate to make migration. 

5/Launch the php artisan serve of project.

