# Mothership Install

## System requirements

To set up <a href="http://mothership.ec">Mothership</a> using the installer, you must have the following:

+ **PHP** 5.4.0 or higher
	+ **PHP intl extention** (see <a href="http://php.net/manual/en/intl.setup.php">http://php.net/manual/en/intl.setup.php</a>)
	+ It is also recommended that you set the memory_limit in your php.ini file to at least 256M, as the process of copying and minifying all the CSS and JavaScript from the individual modules can be quite intensive. However, we hope to optimise this in the future.
+ **MySQL** 5.1.0 or higher
+ **Apache**
	+ **We cannot currently offer any guarantee that Mothership works with Nginx or other server software**
+ A **Unix-like** operating system (i.e. OSX, Linux, etc)
	+ If you are using Windows, it is recommended that you use a virtual machine such as
	 <a href="https://www.virtualbox.org/">VirtualBox</a> to set up your installation.
	+ Please note that **we cannot currently offer any guarantee that Mothership itself will work properly in a Windows environment**
+ **Composer**
	+ Composer is a PHP dependency manager which can be downloaded from <a href="https://getcomposer.org/download/">the Composer website</a>.
	+ It is recommended that you install Composer either globally or by adding the following line to your `.bash_profile`

	```
	alias composer='php /[path/to]/composer.phar'

	```
+ **Git**

You will also need to set up a MySQL root user and blank database before running the script (see <a href="http://dev.mysql.com/doc/refman/5.0/en/creating-database.html">the documentation</a>).


## Installing Mothership
To run the installer, run in the Terminal:

```
$ php <path to>mothership.phar <path> --<option>=<value>
```

**Note:** You must run install the application in an empty directory. The download of the skeleton theme will fail otherwise (see https://github.com/mothership-ec/mothership-install/issues/5)

If you are running from source, you will need to run the `cli.php` file within the repo.

The script will continue to run until Mothership has been fully installed. However, it does require user interaction in order to complete the installation.

The installer will run through the following steps:

+ Download a basic Mothership installation using Composer's `create-project` command
	+ **Note:** This may take a while. You may also see error messages flash up from Composer that read: `
Class Message\Cog\Config\FixtureManager is not autoloadable, can not call post-package-install script` - Do not worry, this is simply because of a command that Composer will attempt to run after each dependency is installed, but can only be run once the `Cog` framework is installed. The command itself is used to copy configuration files over from the individual Mothership modules into the installation
+ **Ask the user for the following details about the installation:**
	+ Website name (defaults to 'My Application')
	+ Default contact email (defaults to 'test@default.com')
	+ The base URL of the application ('default.com')
+ **Ask the user for the following database details (*Note:* It is imperative that you get these details correct. If you get these wrong the installation will fail!):**
	+ Hostname (defaults to '127.0.0.1')
	+ User (defaults to 'user')
	+ Pass (defaults to 'password')
	+ Name (defaults to 'table_name')
+ Run the database migrations i.e. add all the necessary tables
	+ **Note:** This will take a long time, and some error messages will display for failed migrations. Do not worry, this is down to a known issue within Mothership's `Cog` framework and does not affect the installation process
+ Copy 'assets' over to the `public` directory. In this instance, an 'asset' is any file that is required by the browser, such as CSS, JavaScript and image files. It will also minify any CSS or JavaScript files.
+ Create any necessary files that exist within directories of the Mothership installation, such as the `.htaccess` file, and various `.gitignore` files.
+ Recursively change the permissions of the `public` directory to a `0777` permission.
+ **Ask the user for details about the first admin user (*Note:* If you add in the wrong details here, don't worry, they can be edited from the Mothership admin panel - although obviously you will need to log in using the details you entered here)**
	+ Forename
	+ Surname
	+ Email
	+ Password

...and then you're done! You should be able to navigate to your installation in the browser and log in to `[site url]/admin`.

### Options

These options can be parsed into the script anywhere after the path to the `mothership.phar` file, and follow a format of `--[option name]=[value]`. If no `value` is set, it will default to `true`.

You can pass the script the following options:

+ `composer` - This is the path to the `composer.phar` installation (or `bin/composer` if you are running Composer from source). If this is not set, the installer will assume that Composer is install globally.
+ `force` - This option forces the creation of the path directory if it does not already exist. It does not require a value, and is disabled by default.
+ `debug` - This enables 'debug mode', which provides more information if the script fails for any reason. It does not require a value, and is disabled by default.

## Compiling

To compile the installer from source, first you need to clone this repo, run `composer up`, and then run `php compile.php` from within the repository.

This will delete any existing file named `mothership.phar` in the `build` directory and create a new one from the source code.

## TODO
+ Add more command options e.g. self-update, uninstall etc.
+ Windows compatibility

