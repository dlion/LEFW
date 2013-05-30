LEFW
====

Links Every Fuckin' Where
-------------------------

I need to save my links every fuckin' where, every day, every where.
If I'm at university or if I'm at work and I need to save important, funny, interesting or temporary links I have a place to do it.
LEFW it's a simple website to save links.

Ho can I do with this shit ?
----------------------------
* You can divide links by category.
* You can make links private so *you can't see it without a password*
* You can add links 
* You can delete links
* You can modify links

How Can Install it ?
--------------------
* If you want to tray LEFW first of all you have to create a db structure. *You can find `db_structure.sql` file to do it*
* After of it you have to modify the `core/config.php` file adding your `hostname`, `database name`, `database password` and your `*nick*`.
* In this moment you have to add your user manually in the database, put your `name`, `surname`,`nick` (the same of nick in the config file) and a `pass` on the db so you can add, delete and modify links.
* In this moment you have to add your categories manually in the database, put a label and a description.

_That's all!_

Soon
----
* Possibility to add your user with registration page
* Possibility to manage your categories
* Possibility to manage your accounts

Let Me See
----------
[Link Every Fuckin' Where on my server] (http://link.dlion.it)


Who are this stupid fuckin' developer ?
---------------------------------------
Thinking and developed by [DLion] (http://dlion.it)


Dependencies
------------
* `PDO`
* `php 5`
* `MySQL`
* `Kube CSS Framework`
