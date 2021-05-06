# pixel-tracking-php
A simple website to make pixel tracking in your mails

This a simple php application to log in a db who and where your mails have been reading by your correspondants

# Creating a pixel for a mail
Go to your browser and type this url in the navigation bar

https://your/path/createmail.php?subject={{your mail subject it is important for you to recover after, don't worry about spaces}}

Copy the unique identifier displayed on the page.

# Inserting the pixel in your mail

To insert HTML in your email, you will have to search for a kind of insert option in your messaging platform
For example in Thunderbird it is here : 

![image](https://user-images.githubusercontent.com/74455671/117299998-6c871500-ae79-11eb-8476-099087e2a33c.png)

Then paste this \<img src="https://your/path/readmail.php?idmail={{the id of the mail you've created}}" alt=""/>

# See the stats

Go to https://your/path/ and then see your mails identified by their id, subject and datetime.
To see the access of one mail, click on the link.
