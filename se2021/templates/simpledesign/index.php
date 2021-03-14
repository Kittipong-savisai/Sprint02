<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'functions.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
<head>
<jdoc:include type="head" />
<script type="text/javascript">
jQuery(function ($) {   
$("<select />").appendTo("#menu");
$("<option />", {
"selected": "selected",
"value"   : "",
"text"    : "Menu"
}).appendTo("#menu select");
$("#menu a").each(function() {
var el = $(this);
$("<option />", {
"value"   : el.attr("href"),
"text"    : el.text()
}).appendTo("#menu select");
});
$("#menu select").change(function() {
window.location = $(this).find("option:selected").val();
});
});
</script>
</head>

<body>
<div class="clearbreak">
<div id="container">
<div id="header">
<div id="logo">
<img class="logo" src="<?php echo $this->baseurl ?>/<?php echo "$logo"; ?>" />
</div>
<?php if($this->countModules('header')) : ?>
<div id="head">
<jdoc:include type="modules" name="header" style="none" />
</div>
<?php endif; ?>
</div>
</div>
</div>
<div class="clearbreak">
<div id="container">
<div id="navigation">
<div id="menu">
<jdoc:include type="modules" name="menu" style="none" />
</div>
<?php if($this->countModules('search')) : ?>
<div id="search">
<jdoc:include type="modules" name="search" style="none" />
</div>
<?php endif; ?>
</div>
</div>
</div>
<?php if($this->countModules('banner')) : ?>
<div class="clearbreak">
<div id="container">
<div id="banner">
<jdoc:include type="modules" name="banner" style="none" />
</div>
</div>
</div>
<?php endif; ?>
<div class="clearbreak">
<div id="container">
<div id="content">
<?php if($this->countModules('left')) : ?>
<div id="left<?php echo getLayout($left,$right); ?>" class="layout">
<jdoc:include type="modules" name="left" style="modtitle" />
</div>
<?php endif; ?>
<div id="content<?php echo getLayout($left,$right); ?>">
<?php if ($this->countModules('user1') or $this->countModules('user2') or $this->countModules('user3')) : ?>
<div id="user<?php echo getLayout($left,$right); ?>" class="clearbreak">
<div class="<?php echo $user_a_floor; ?>">
<?php if($this->countModules('user1')) : ?>
<div class="user one">
<jdoc:include type="modules" name="user1" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('user2')) : ?>
<div class="user two">
<jdoc:include type="modules" name="user2" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('user3')) : ?>
<div class="user three">
<jdoc:include type="modules" name="user3" style="modtitle" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php if ($this->countModules('user4') or $this->countModules('user5') or $this->countModules('user6')) : ?>
<div id="user<?php echo getLayout($left,$right); ?>" class="clearbreak">
<div class="<?php echo $user_b_floor; ?>">
<?php if($this->countModules('user4')) : ?>
<div class="user one">
<jdoc:include type="modules" name="user4" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('user5')) : ?>
<div class="user two">
<jdoc:include type="modules" name="user5" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('user6')) : ?>
<div class="user three">
<jdoc:include type="modules" name="user6" style="modtitle" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<div class="clearbreak">
<jdoc:include type="message" />
<jdoc:include type="component" />
</div>
<?php if ($this->countModules('user7') or $this->countModules('user8') or $this->countModules('user9')) : ?>
<div id="user<?php echo getLayout($left,$right); ?>" class="clearbreak">
<div class="<?php echo $user_c_floor; ?>">
<?php if($this->countModules('user7')) : ?>
<div class="user one">
<jdoc:include type="modules" name="user7" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('user8')) : ?>
<div class="user two">
<jdoc:include type="modules" name="user8" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('user9')) : ?>
<div class="user three">
<jdoc:include type="modules" name="user9" style="modtitle" />
</div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
</div>
<?php if($this->countModules('right')) : ?>
<div id="right<?php echo getLayout($left,$right); ?>" class="layout">
<jdoc:include type="modules" name="right" style="modtitle" />
</div>
<?php endif; ?>
</div>
</div>
</div>
<?php if($this->countModules('footer1') or $this->countModules('footer2') or $this->countModules('footer3') or $this->countModules('footer4') or $this->countModules('footer5')) : ?>
<div class="clearbreak">
<div id="container" class="<?php echo $footer_floor; ?>">
<div id="footer">
<?php if($this->countModules('footer1')) : ?>
<div class="footer one">
<jdoc:include type="modules" name="footer1" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer2')) : ?>
<div class="footer two">
<jdoc:include type="modules" name="footer2" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer3')) : ?>
<div class="footer three">
<jdoc:include type="modules" name="footer3" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer4')) : ?>
<div class="footer four">
<jdoc:include type="modules" name="footer4" style="modtitle" />
</div>
<?php endif; ?>
<?php if($this->countModules('footer5')) : ?>
<div class="footer five">
<jdoc:include type="modules" name="footer5" style="modtitle" />
</div>
<?php endif; ?>
</div>
</div>
</div>
<?php endif; ?>
<div class="clearbreak">
<div id="container">
<div id="copyright">
<div id="copy">Copyright &copy; <?php echo date("Y"); ?> <?php echo "$sitename"; ?>. All Right Reserved.</div>
<div id="design">Design By <a href="http://www.primerthemes.com" target="_blank">Primer Themes</a></div>
</div>
</div>
</div>
</body>
</html>