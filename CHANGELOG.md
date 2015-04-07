# Change log

## 0.1.0

- Use Composer's `create-project` command instead of using Git to download the theme
- Download theme from the `mothership-ec/mothership` repo instead of `mothership-ec/mothership-skeleton-theme` repo to shift file creation responsibility to Mothership rather than its installer
- Remove `Message\\` from namespaces
- Installer now takes the install path as its first argument
- All arguments other than the install path are declared using the --[name]=[value] syntax
- No longer aborts installation process if database details are entered incorrectly

## 0.0.3

- Fix broken bash statement, installer can now be run as an executable

## 0.0.2

- Escape if directory is not empty
- Escape if theme could not be downloaded
- Escape if database connection cannot be established
- Escape if database is not empty
- Escape if config files cannot be loaded
- Add bash to cli.php
- Changed colour of error messages

## 0.0.1

- Initial release