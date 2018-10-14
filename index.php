<!doctype html>
<html lang="en">
<?php
session_start();
require_once "PHP/default.php";
include_once('header.php');
?>
<!-- need to add - logout functionality to menu -->
<!-- need to add - graduate confirmation to register form -->


<body>
    <title>Research Assistant Database</title>
  	
  <div id="ii4vcy" class="row c3690">
        <form action = "registration.php" method = "post">
            <input type = "submit" value = "Please sign in"/>
        </form>
  </div>
    
    <script>
	
        var items = document.querySelectorAll('#iitw8i');
        for (var i = 0, len = items.length; i < len; i++) {
            (function() {
                var t, e = this,
                    a = "[data-tab]",
                    n = document.body,
                    r = n.matchesSelector || n.webkitMatchesSelector || n.mozMatchesSelector || n.msMatchesSelector,
                    o = function() {
                        var a = e.querySelectorAll("[data-tab-content]") || [];
                        for (t = 0; t < a.length; t++) a[t].style.display = "none"
                    },
                    i = function(n) {
                        var r = e.querySelectorAll(a) || [];
                        for (t = 0; t < r.length; t++) {
                            var i = r[t],
                                s = i.className.replace("tab-active", "").trim();
                            i.className = s
                        }
                        o(), n.className += " tab-active";
                        var l = n.getAttribute("href"),
                            c = e.querySelector(l);
                        c && (c.style.display = "")
                    },
                    s = e.querySelector(".tab-active" + a);
                s = s || e.querySelector(a), s && i(s), e.addEventListener("click", function(t) {
                    var e = t.target;
                    r.call(e, a) && i(e)
                })
            }.bind(items[i]))();
        }
    </script>
	<footer>
		foot
	</footer>
</body>
<html>