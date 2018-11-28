# Communicator
An instant messenger written in Javascript with emoticons library on a client side and PHP on a server side. Communicator using 
MySQL database to store messages. AJAX long pooling is looking for new messages in the database all the time and if it find them it
send them to all users. Users can send messages and read them from naother users. Additionaly application deletes very old messages
from database to prevent data redundancy in the database.
