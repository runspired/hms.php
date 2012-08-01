# hms.php

by James Thoburn, http://jthoburn.com

Dual licensed under the MIT or GPL Version 2 licenses.

## About

hms.php is a class for handling the time format for athletic events such as running that require the h:mm:ss format.

Initialize an hms instance just like any other PHP class.  `$time = new hms();`

The constructor takes up to 3 arguments: h,m,s or m,s or seconds

## Methods

hms has the following public methods.

	->hours(arg1,arg2)
	
	->minutes(arg1,arg2)
	
	->seconds(arg1,arg2)
	
Each of the above methods acts as both a getter and a setter.  No arguments or a single `boolean` argument will return the requested parameter.
Passing `true` as `arg1` will return the complete time converted to desired parameter.
	
	->getFormat()

Returns the string value of what the format of a call to `toString()` currently would produce.  `hms.php` formats time strings to be as minimalistic as possible, so in the absence of hours the string will be in `m:ss` format, and in the absence of both hours and minutes it will be in `seconds` format. Otherwise `h:mm:ss` is used.
	
	->lastFormat()
	
Returns the string value of the last call to `toString()`.  Use this instead of `getFormat()` if there's a possibility that the time has changed since the last call to `toString()`.
	
	->toString()
	
Returns the time as a string minimally formatted to `h:mm:ss`