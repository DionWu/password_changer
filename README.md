Hello!

This is the first project of mine whilst learning PHP/MySQLi fundamentals.

It is a simple password changer. Originally intended to take a user's Facebook password, change it, and email the new password to the user after a specified duration, this little code was meant to be an anti-procrastination tool.

However, upon learning that it is actually illegal and against Facebook's TOS to solicit passwords as well as change them through some sort of script (impossible as far as my knowledge goes), I changed it up. 

This script simply generates a new password, emailing it to the user for him/her to manually change and hopefully discard. It then sends the same password in another email after the specified duration. A little lame and counterintuitive, yes I know, but hey, it was a great learning experience.

pw_changer.sql generates a sql database to hold emails & start/stop entry times.
pw_changer.php is a simple website script with a form for users to fill out.
process.php connects to SQL database and performs checks.
mail.php is the mail script that utilizes phpscheduler and phpmailer to automatically check if there is an email to be sent every hour.

Things I learned from this project:
- How to use PHP to send user inputted data to an SQL database
- How to use automated schedulers (e.g. phpjobscheduler) & other external PHP addons to perform functions (phpmailer-master)
- Playing with the mysqli object
- Surface level security preventing against sql injections (preparing statements, binding parameters, and escaping strings)

Still much to learn, but very excited to have this one project turn out okay!