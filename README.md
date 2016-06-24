# Showtime 
#### A movie database website built in PHP

![Showtime Logo](http://i.imgur.com/QGuoSzY.png "Showtime Logo")

# Introduction

This website was built for a Web Development class at Instituto Politécnico de Bragança and is merely intended for academic purposes. Any security flaws it might have were not seen as relevant because of this.

# Configuration

The website was tested on Google Chrome (51.0.2704.84) and Mozilla Firefox (46.0.1), running on Apache with PHP 5.6. The following settings were modified on the php.ini file:

file_uploads=On 

upload_max_filesize=10M 

post_max_size=15M

# Bugs

There's a problem with the featured widget implementation which causes the animation to continue even if the user has selected a movie.
