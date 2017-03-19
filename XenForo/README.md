## XenForo support

So this is a bit of a pain but it works (at least on version 1.5.12 it does anyway, it should work on other versions)

Login as an admin, head to the appearance tab and create a new Template named `byondlink_verifyToken`, The contents of this should be:
```
<xen:if is="{$has_error}">
<h3>Error while linking your account: {$error}</h3>
<xen:else />
<h3>Well done, you've linked your BYOND key: {$ckey} to your forum account</h3>
</xen:if>
```

Once you've done this head to Users and add a new Custom User Field with the following settingsm, the rest can be left as default:
- Field ID: ckey
- Field Type: Single-line text box
- General Options -> User editable MUST BE SET TO OFF, otherwise the system is useless.


Once you've done this go ahead and upload the `HippieStation` folder inside of the library folder into the library folder on your XenForo server.

Now that you've done this, you'll need to create a new page with the following settings:

- Basic Information
    - URL Portion: byondlink-verify
    - Title: Verify BYOND Token
- PHP Callback
    - PHP Callback: `HippieStation_BYONDLink_main :: verifyToken`

I also suggest adding a Link Forum with the Link URL set to `https://secure.byond.com/login.cgi?login=1;noscript=1;url=http://www.byond.com/play/YOUR_IP:YOUR_PORT`

Now that you've done this, you'll need to edit `world.dm` and `redirector.dms`

- world.dm needs to have the link to the storeCkey.php script on your server set, ideally host this on the same server as the server running the verifier server
- redirector.dms needs to have the link in the JavaScript function changed, this is what it should look like: `"https://yourwebsite.com/pages/byondlink-verify/?token=" + token`
