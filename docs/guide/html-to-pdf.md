Install WKHTMLTOPDF
Manually install dependency

sudo apt-get install xfonts-75dpi


Download the latest package, currently 0.12.2.1

wget http://download.gna.org/wkhtmltopdf/0.12/0.12.2.1/wkhtmltox-0.12.2.1_linux-precise-amd64.deb


Install the wkhtmltopdf package

sudo dpkg -i wkhtmltox-0.12.2.1_linux-precise-amd64.deb


Move wkhtmltopdf from default install directory

sudo mv /usr/local/bin/wkhtmltopdf /usr/bin/wkhtmltopdf


Install xvfb

sudo apt-get install xvfb


Create Shell Script to wrap the wkhtmltopdf command in xvfb

echo 'xvfb-run -a -s "-screen 0 640x480x16" wkhtmltopdf "$@"' > /usr/bin/wkhtmltopdf.sh


Give proper permissions to script so it can be read and executed

chmod a+rx /usr/bin/wkhtmltopdf.sh


Create symlink to new script

sudo ln -s /usr/local/bin/wkhtmltopdf.sh /usr/bin/wkhtmltopdf


Test wkhtmltopdf http://www.google.com output.pdf
