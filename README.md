LEFW - Links Every Fuckin' Where
================================
I need to save my links every fuckin' where, every day.

If I'm at university or if I'm at work and I need to save important, funny, interesting or temporary links _have a place to do it_.

*LEFW* it's a _simple_ website to _save links_.

What Can I Do With This Shit ?
----------------------------
* You can divide links by category.
* You can make links private so *you can't see it without a password*
* You can add links 
* You can delete links
* You can edit links
* You can add categories
* You can delete categories
* You can edit categories

How Can Install It ?
--------------------
* If you want to try LEFW first of all you have to create a db structure. *You can find `db_structure.sql` file to do it*
* After of it you have to modify the `core/config.php` file adding your `hostname`, `database name`, `database password` and your *`nick`*.
* *In this moment you have to add your user manually in the database*, put your `name`, `surname`,`nick` ( *the same of nick in the config.php file* ) and a `pass` on the db so you can add, delete and modify links.
* *In this moment you have to add General category manually in the database*, put as `label` 'General' and `description` is free, remember `General` as `label`.

Soon
----
* Possibility to add your user with registration page
* Possibility to manage your accounts

Let Me See
----------
[Link Every Fuckin' Where on my server] (http://link.dlion.it)


Who Is This Stupid Fuckin' Developer ?
---------------------------------------
Thinking and developed by [DLion] (http://dlion.it)


Dependencies
------------
* `PDO`
* `php 5`
* `MySQL`
* `Kube CSS Framework`
