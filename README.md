# hms.php

by James Thoburn, http://jthoburn.com

Dual licensed under the MIT or GPL Version 2 licenses.

## About

hms.php is a class for handling the time format for athletic events such as running that require the h:mm:ss format.

Initialize an hms instance just like any other PHP class.  $time = new hms();

The constructor takes up to 3 arguments: h,m,s || m,s || seconds

## Methods

hms has the following public methods.

	->hours(arg1,arg2)
	
	->minutes(arg1,arg2)
	
	->seconds(arg1,arg2)
	
	->getFormat()
	
	->lastFormat()
	
	->toString()